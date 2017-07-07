<?php

namespace NumoBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @Route("/list-published", name="event_list_published")
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
            'limit' => 300,
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

        $paginator = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $events,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 7)/*limit per page*/
        );

        // --- affichage
        return $this->render('NumoBundle:event:listPublished.html.twig', [
            'selectForm' => $selectForm->createView(),
            'agendaSlug' => $api->getAgendaSlug(),
            'events' => $events,
            'dates' => $dates,
            'error' => $error,
            'nbEvents' => $nbEvents,
            'pages' => $pages,
            'googleMapApi' => $this->getParameter('google_map_api')
        ]);
    }

    /**
     * Creates a new event, and register (locally or on OpenAgenda).
     *
     * @Route("/new", name="event_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        // --- Note : les images sont gerees par des eventlisteners
        $error = '';
        $event = new Event();
        $firstEvtDate = new EvtDate();
        $firstEvtDate->setEvtDate(new \DateTime());
        $firstEvtDate->setEvent($event);
        $event->getEvtDates()->add($firstEvtDate);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $company = $em->getRepository('NumoBundle:Company')->findAll()[0];


        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'info',
                'Vous avez créé un évènement'
            );
            $userManager = $this->get('fos_user.user_manager');
            $users = $userManager->findUsers();

            $curentUser = $this->getUser();
            $event
                ->setAuthor($curentUser)
                ->setCreationDate(new \DateTime);
            if ($curentUser->getTrust() == 1) {
                // --- si utilisateur de confiance, on publie directement

                $confirmation = \Swift_Message::newInstance()
                    ->setSubject('Un membre de confiance à posté un événement')
                    ->setBody('Bonjour, 
                            Un membre de confiance à posté un événement, vous pouvez aller sur www.num-o.fr pour le voir.')
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
                $published->setTitle($event->getTitle());
                $em->persist($published);
                $em->flush();
            } else {
                // --- sinon enregistrement de l'evenement dans la database
                $em->persist($event);
                $em->flush();

                $confirmation = \Swift_Message::newInstance()
                    ->setSubject('Un membre à posté un événement')
                    ->setBody('Bonjour, 
                            Un membre à posté un événement, vous pouvez aller sur www.num-o.fr pour le moderer.')
                    ->setFrom($company->getContactEmail());
                foreach ($users as $user) {
                    if (in_array('ROLE_MODERATOR', $user->getRoles())) {
                        $confirmation->setTo($user->getEmail());
                    }
                }
                $this->get('mailer')->send($confirmation);
            }

            return $this->redirectToRoute('event_list_published');
        }
        return $this->render('NumoBundle:event:new.html.twig', [
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }


    /**
     * Displays an awaiting event.
     *
     * @Route("/show-await/{id}", name="event_show_await")
     * @Method("GET")
     */
    public function showAwaitAction(Event $event)
    {
        $imgDir = $this->getParameter('img_event_dir');
        $oldDates = $newDates = [];
        $dateRef = new \DateTime();
        foreach ($event->getEvtDates() as $evtD) {
            $evtDate = [
                'evtDate' => $evtD->getEvtDate()->format('Y-m-d'),
                'timeStart' => $evtD->getTimeStart()->format('H:i'),
                'timeEnd' => $evtD->getTimeEnd()->format('H:i')
            ];
            if ($evtDate['evtDate'] < $dateRef->format('Y-m-d')) {
                $oldDates[] = $evtDate;
            } else {
                $newDates[] = $evtDate;
            }
        }
        return $this->render('NumoBundle:event:showAwait.html.twig', [
            'imgDir' => $imgDir,
            'event' => $event,
            'oldDates' => $oldDates,
            'newDates' => $newDates,
        ]);
    }

    /**
     * displays a published event.
     *
     * @Route("/show-published/{id}", name="event_show_published")
     * @Method({"GET", "POST" })
     */
    public function showPublishedAction(Request $request, $id)
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

            $this->addFlash(
                'success',
                'Votre message à bien été envoyé'
            );

            $commentaire = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setFrom($contact->getEmail())
                ->setTo($published->getAuthor()->getEmail())
                ->setBody($contact->getCommentaire());

            $this->get('mailer')->send($commentaire);
        }

        if($form->isSubmitted() != $form->isValid() ){

            $this->addFlash(
                'danger',
                'Une erreur est survenue lors de l\'envoi de votre message'
            );
        }

        return $this->render('NumoBundle:event:showPublished.html.twig', [
            'agendaSlug' => $api->getAgendaSlug(),
            'event' => $event,
            'published' => $published,
            'error' => $error,
            'form'=>$form->createView(),
            'googleMapApi' => $this->getParameter('google_map_api')

        ]);

    }

    /**
     * Edit an awaiting event.
     *
     * @Route("/edit-await/{id}", name="event_edit_await")
     * @Method({"GET", "POST"})
     */
    public function editAwitAction(Request $request, Event $event)
    {
        // --- Note : les images sont gerees par des eventlisteners
        $imgDir = $this->getParameter('img_event_dir');
        $em = $this->getDoctrine()->getManager();
        $oldImage = $event->getImage();
        $originalEvtDates = new ArrayCollection();
        foreach ($event->getEvtDates() as $evtDate) {
            $originalEvtDates->add($evtDate);
        }
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // --- adaptation de la liste des dates
            foreach ($originalEvtDates as $evtDate){
                if (false === $event->getEvtDates()->contains($evtDate)) {
                    $em->remove($evtDate);
                }
            }
            $event
                ->setAuthor($this->getUser())
                ->setCreationDate(new \datetime());
            $em->flush();

            return $this->redirectToRoute('event_show_await', ['id' => $event->getId()]);
        }

        return $this->render('NumoBundle:event:editAwait.html.twig', [
            'event' => $event,
            'imgDir' => $imgDir,
            'eventId' => $event->getId(),
            'oldImage' => $oldImage,
            'form' => $form->createView(),
        ]);

    }

    /**
     * Deletes an awaiting event.
     *
     * @Route("/delete-await/{id}", name="event_delete_await")
     * @Method({"GET","POST"})
     */
    public function deleteAwaitAction(Request $request, Event $event)
    {
        // --- Note : les images sont gerees par des eventlisteners
        $imgDir = $this->getParameter('img_event_dir');
        $form = $this
            ->createFormBuilder()
            ->add('delete', SubmitType::class, ['label' => 'Supprimer'])
            ->getForm();
        $form->handleRequest($request);
        // --- generation des tableaux dates pour affichage
        $oldDates = $newDates = [];
        $dateRef = new \DateTime();
        foreach ($event->getEvtDates() as $eventDate) {
            $evtDate = [
                'evtDate' => $eventDate->getEvtDate()->format('Y-m-d'),
                'timeStart' => $eventDate->getTimeStart()->format('H:i'),
                'timeEnd' => $eventDate->getTimeEnd()->format('H:i')
            ];
            if ($evtDate['evtDate'] < $dateRef->format('Y-m-d')) {
                $oldDates[] = $evtDate;
            } else {
                $newDates[] = $evtDate;
            }
        }
        // --- definition de la route de retour
        if (in_array('ROLE_MODERATOR', $this->getUser()->getRoles())) {
            // --- Si moderateur ou admin -> retour sur page admin
            $goBack = 'events_index';
        } else {
            // --- Sinon retour sur page profil de l'utilisateur
            $goBack = 'fos_user_profile_show';
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // --- suppression de l'évènement en base de donnees
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
            return $this->redirectToRoute($goBack);
        }
        return $this->render('NumoBundle:event:deleteAwait.html.twig', [
            'imgDir' => $imgDir,
            'event' => $event,
            'form' => $form->createView(),
            'goBack' => $goBack,
            'oldDates' => $oldDates,
            'newDates' => $newDates,
        ]);
    }

    /**
     * Deletes a published event.
     *
     * @Route("/delete-published/{id}", name="event_delete_published")
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

    /**
     * Deletes an image in event entity.
     *
     * @Route("/delete-image/{id}", name="event_delete_image")
     * @Method({"GET", "POST"})
     */
    public function deleteImageAction(Event $event)

    {
        $path = $event->getImage();
        $em = $this->getDoctrine()->getManager();
        $event->setImage('');
        $em->flush();
        // effacement du fichier
        unlink($this->getParameter('upload_directory') . '/' .
            $path);
        return $this->redirectToRoute('event_edit_await', array('id' => $event->getId()));
    }

    /**
     * Publish an event approved by a moderator.
     *
     * @Route("/approved/{id}", name="event_approved")
     * @Method({"GET","POST"})
     */
    public function ApprovedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('NumoBundle:Event')->findOneBy(['id' => $id]);

        if ($event->getImage() == null){
            $event->setImage(' ');
        }

        $author = $event->getAuthor();

        $api = $this->get('numo.apiopenagenda');
        $uid = $api->publishEvent($event);

        $eventUid = $uid['eventUid'];

        // --- creationde l'enregistrement "published"
        $published = new Published($event, $eventUid, $author);
        $published->setTitle($event->getTitle());
        $em->persist($published);
        $em->remove($event);
        $em->flush();

        $events = $em->getRepository('NumoBundle:Event') ->findAll();
        $publishedevents = $em->getRepository('NumoBundle:Published')->findBy(array(), array('authorUpdateDate'=> 'DESC'));

        return $this -> render('events/index.html.twig', array(
            'events'=> $events,
            'publishedevents' =>$publishedevents
        ));
    }
}
