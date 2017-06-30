<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;
use NumoBundle\Entity\EvtDate;
use NumoBundle\Entity\Published;
use NumoBundle\Entity\SelectEvent;
use NumoBundle\Form\SelectEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use NumoBundle\Form\EventType;
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
            'dates'=> $dates,
            'error' => $error,
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
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $event->getImage();
            $fileName = $this->getParameter('server_url').'/'.$this->getParameter('img_event_dir').'/'.uniqid().'.'.$file->guessExtension();
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
     * @Method("GET")
     */
    public function showAction($id)
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
        return $this->render('NumoBundle:event:showPublished.html.twig', [
            'agendaSlug' => $api->getAgendaSlug(),
            'event' => $event,
            'published' => $published,
            'error' => $error,
        ]);
    }

    /**
     * Displays a form to edit an existing event entity.
     *
     * @Route("/editpublished/{id}", name="event_edit_published")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $error = '';
        $api = $this->get('numo.apiopenagenda');
        // --- lecture de l'évènement via json sur OpenAgenda (2ème paramètre getEvent omis)
        $oaEvent = $api->getEvent($id);
        if (false === $oaEvent) {
            $oaEvent = null; // objet vide
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        } else {
            $event = new Event();
            $event->hydrate($oaEvent);
            $evtDate = new EvtDate();
            foreach ($oaEvent->getOldDates() as $oaDate) {
                $evtDate->setEvtDate(new \DateTime($oaDate['evtDate']));
                $evtDate->setTimeStart(\DateTime::createFromFormat('H:i:s', $oaDate['timeStart']));
                $evtDate->setTimeEnd(\DateTime::createFromFormat('H:i:s', $oaDate['timeEnd']));
                $event->getEvtDates()->add($evtDate);
            }
            foreach ($oaEvent->getNewDates() as $oaDate) {
                $evtDate->setEvtDate(new \DateTime($oaDate['evtDate']));
                $evtDate->setTimeStart(\DateTime::createFromFormat('H:i:s', $oaDate['timeStart']));
                $evtDate->setTimeEnd(\DateTime::createFromFormat('H:i:s', $oaDate['timeEnd']));
                $event->getEvtDates()->add($evtDate);
            }
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);


            // charger le formulaire avec ces infos

            if ($form->isSubmitted() && $form->isValid()) {


//                return $this->redirectToRoute('event_list_published');
            }
        }
        return $this->render('NumoBundle:event:editPublished.html.twig', [
        'error' => $error,
        'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/deletepublished/{id}", name="event_delete_published")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Event $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
    }
}
