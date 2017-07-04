<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Company;
use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;
use NumoBundle\Entity\EvtDate;
use NumoBundle\Entity\Published;
use NumoBundle\Entity\SelectEvent;
use NumoBundle\Form\SelectEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use NumoBundle\Form\EventType;
use NumoBundle\Entity\Contact;
use NumoBundle\Form\ContactType;


/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends Controller
{

    /**
     * Lists all published events.
     *
     * @Route("/listpublished", name="event_list_published")
     * @Method("GET")
     * -- Liste les évènements -------------------------------------------------------------------------------------
     *      - par défaut : liste tous les évènements publiés à venir (provenance OpenAgenda)
     *      - via sélecteurs :
     *          - sélecteur de période (date de début et date de fin - Note : dates passées possibles)
     *              seuls les évènement ayant au moins une date entrant dans la plage seront affichés
     *          - sélecteur de catégorie (recherche dans le champ "tags" des evenements)
     *      Note : les sélecteurs sont cumulables
     * -------------------------------------------------------------------------------------------------------------
     */
    public function listPublishedAction(Request $request)

// ---------------------------------------------------------------------------
//  manque la pagination des evenements (si liste > 10 elements)
//  finir le selecteur (ajouter validateur sur dates et checkbox passed)
//  ??? calendrier a remettre (sous la map) ???
// ---------------------------------------------------------------------------

    {

        $error = '';
        // --- initialisation des parametres de lecture par defaut de la liste des evenements
        $options = [
            'search[passed]' => 0,
            'offset' => 0,
            'limit' => 10,
        ];
        $selector = new SelectEvent();
        $selectForm = $this->createForm(SelectEventType::class, $selector);
        $selectForm->handleRequest($request);

        if ($selectForm->isSubmitted() && $selectForm->isValid()) {

            // --- contrôle dates
            // - si une seule date , 2eme date = date saisie
            if ($selector->getStartDate() && !$selector->getEndDate()) {
                $selector->setStartDate($selector->getEndDate());
            } elseif ($selector->getEndDate() && !$selector->getStartDate()) {
                $selector->setEndDate($selector->getStartDate());
            }
            // - si date deb apres date fin, inverser dates
            if ($selector->getStartDate() > $selector->getEndDate()) {
                $tmpDate = $selector->getStartDate();
                $selector->setStartDate($selector->getEndDate());
                $selector->setEndDate($tmpDate);
            }

            // --- creation des options d'affichage
            if ($selector->getStartDate()) {
                $options['oaq[from]'] = $selector->getStartDate()->format('Y-m-d');
                $options['oaq[to]'] = $selector->getEndDate()->format('Y-m-d');
                $selector->setPassed(1);
            }
            if ($selector->getCategory()) {
                $options['oaq[what]'] = urlencode($selector->getCategory()->getName());
                $selector->setPassed(1);
            }
            $options['search[passed]'] = $selector->getPassed();
        }

        // --- lecture de la liste OpenAgenda
        $api = $this->get('numo.apiopenagenda');
        $data = $api->getEventList($options);
        $events = $data['eventList'];
        $nbEvents = $data['nbEvents'];
        $dates = $data['eventDateList'];
        if (false === $events) {
            $events = [];
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        }
        // --- affichage
        return $this->render('NumoBundle:event:listPublished.html.twig', [
            'selectForm' => $selectForm->createView(),
            'agendaSlug' => $api->getAgendaSlug(),
            'events' => $events,
            'dates' => $dates,
            'error' => $error,
            'googleMapApi' => $this->getParameter('google_map_api')
        ]);
    }

    /**
     * Creates a new event, and register locally.
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $error = '';
        $event = new Event();
        $evtDate0 = new EvtDate();
        $evtDate0->setEvtDate(new \DateTime());
        $event->getEvtDates()->add($evtDate0);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('NumoBundle:Company')->findAll()[0];


        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $users = $userManager->findUsers();

            $file = $event->getImage();
            $fileName = $this->getParameter('server_url') . '/' . $this->getParameter('img_event_dir') . '/' . uniqid() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory_event'),
                $fileName
            );
            $curentUser = $this->getUser();
            $event
                ->setImage($fileName)
                ->setAuthor($curentUser)
                ->setCreationDate(new \DateTime);
            $em = $this->getDoctrine()->getManager();
            if ($curentUser->getTrust() == 1) {
                // --- si utilisateur de confiance, on publie directement

                $confirmation = \Swift_Message::newInstance()
                    ->setSubject('Un membre de confiance à posté un événement')
                    ->setBody('Bonjour, Un membre de confiance à posté un événement, veuillez aller sur www.numo.fr pour le voir')
                    ->setFrom($company->getContactEmail());
                foreach ($users as $user) {
                    if (in_array('ROLE_MODERATOR', $user->getRoles())) {
                        $confirmation->setTo($user->getEmail());
                    }
                }

                $this->get('mailer')->send($confirmation);

                $api = $this->get('numo.apiopenagenda');
                $uid = $api->publishEvent($event);
                if (false === $uid) {
                    // gerer erreur si ecriture foireuse
                }
                // --- creationde l'enregistrement "published"
                $published = new Published($event, $uid, $curentUser);
                $em->persist($published);
                $em->flush();
            } else {
                // --- sinon enregistrement de l'evenement dans la database
                $em->persist($event);
                $em->flush();

                $confirmation = \Swift_Message::newInstance()
                    ->setSubject('Un adhérent à posté un événement')
                    ->setBody('Bonjour, Un adhérent à posté un événement, veuillez aller sur www.numo.fr pour confirmer')
                    ->setFrom($company->getContactEmail());
                foreach ($users as $user) {
                    if (in_array('ROLE_MODERATOR', $user->getRoles())) {
                        $confirmation->setTo($user->getEmail());
                    }
                }
                $this->get('mailer')->send($confirmation);
            }
            // --- on envoie une notification au(x) moderateur(s)
            // A creer




            return $this->redirectToRoute('event_list_published');
        }
        return $this->render('NumoBundle:event:new.html.twig', [
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a published event.
     *
     * @Route("/showpublished/{id}", name="event_show_published")
     * @Method({"GET", "POST" })
     */
    public function showAction(Request $request, $id)
    {
        $error = '';
        $published = null;
        $api = $this->get('numo.apiopenagenda');
        // --- lecture de l'évènement via json sur OpenAgenda (2ème paramètre getEvent omis)
        $event = $api->getEvent($id);
        if (false === $event) {
            $event = null; // objet vide
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        } else {
            // --- lecture des infos complementaires
            $em = $this->getDoctrine()->getManager();
            $published = $em->getRepository('NumoBundle:Published')->findOneByUid($id);
        }
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $commentaire = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setFrom($contact->getEmail())
                ->setTo($published->getAuthor()->getEmail())
                ->setBody($contact->getCommentaire());

            $this->get('mailer')->send($commentaire);
        }


        return $this->render('NumoBundle:event:showPublished.html.twig', [
            'agendaSlug' => $api->getAgendaSlug(),
            'event' => $event,
            'published' => $published,
            'error' => $error,
            'form'=>$form->createView(),
        ]);

    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/{id}/edit", name="event_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Event $event)
    {
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/deletepublished/{id}", name="event_delete_published")
     * @Method({"GET","POST"})
     */
    public function deletePublishedAction(Request $request, $id)
    {
        $error = '';
        $api = $this->get('numo.apiopenagenda');
        $form = $this
            ->createFormBuilder()
            ->add('delete', SubmitType::class, ['label' => 'Supprimer'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // --- suppression de l'évènement sur OpenAgenda
            $result = $api->deleteEvent($id);
            if (false === $result) {
                $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
            } else {
                // --- Mise a jour des infos complementaires
                $em = $this->getDoctrine()->getManager();
                $published = $em->getRepository('NumoBundle:Published')->findOneByUid($id);
                if ($published) {
                    $published->setDeleted(1);
                    $published->setModerator($this->getUser());
                    $published->setModeratorUpdateDate(new \DateTime);
                    $em->flush();
                }
                return $this->redirectToRoute('event_list_published');
            }
        }
        // --- lecture de l'évènement via json sur OpenAgenda (2ème paramètre getEvent omis)
        $oaEvent = $api->getEvent($id);
        if (false === $oaEvent) {
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        } else {
            // --- lecture des infos complementaires
            $em = $this->getDoctrine()->getManager();
            $published = $em->getRepository('NumoBundle:Published')->findOneByUid($id);
        }
        return $this->render('NumoBundle:event:deletePublished.html.twig', [
            'agendaSlug' => $api->getAgendaSlug(),
            'event' => $oaEvent,
            'published' => $published,
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
