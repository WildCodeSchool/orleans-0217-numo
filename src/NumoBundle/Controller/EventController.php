<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;
use NumoBundle\Entity\EvtDate;
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
     * Lists all event entities.
     *
     * @Route("/list", name="event_list")
     * @Method({"GET", "POST"})
     * -- Liste les évènements -------------------------------------------------------------------------------------
     *      - par défaut : liste tous les évènements publiés à venir (provenance OpenAgenda)
     *      - via sélecteurs :
     *          - sélecteur de période (date de début et date de fin - Note : dates passées possibles)
     *              seuls les évènement ayant au moins une date entrant dans la plage seront affichés
     *          - sélecteur de catégories (recherche dans le champ "tags" des evenements)
     *      Note : les sélecteurs sont cumulables
     * -------------------------------------------------------------------------------------------------------------
     */
    public function listAction(Request $request)
    {
        $error = '';
//        $event = new Event();
        // --- initialisation des parametres de lecture par defaut de la liste des evenements
        $options = [
            'search[passed]' => 0,  // pas de sélection des évènements passés
            'offset' => 0,          // début de la liste
            'limit' => 10,          // nombre d'éléments retournés
        ];
        $selector = new SelectEvent();
        $selectForm = $this->createForm(SelectEventType::class, $selector);
        $selectForm->handleRequest($request);

        if ($selectForm->isSubmitted() && $selectForm->isValid()) {
            $selector->DatesControl();
            // --- creation des options d'affichage
            if ($selector->getStartDate() && $selector->getEndDate()) {
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

        $data = $api->getEventList($options, false);
        $events = $data['eventList'];
        $dates = $data['eventDateList'];
        if (false === $events) {
            $events = [];
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        }
        // --- affichage
        $twigParams = [
            'selectForm' => $selectForm->createView(),
            'agendaSlug' => $api->getAgendaSlug(),
            'events' => $events,
            'dates'=> $dates,
            'error' => $error,
            'selector' => $selector,
            'selectForm' => $selectForm->createView(),
        ];
        return $this->render('NumoBundle:event:list.html.twig', $twigParams);
    }




    /**
     * Creates a new event entity.
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
        $form = $this->createForm('NumoBundle\Form\EventType', $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $event->getImage();
            $fileName = $this->getParameter('server_url').'/'.$this->getParameter('img_event_dir').'/'.uniqid().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('upload_directory_event'),
                $fileName
            );
            $event->setImage($fileName);
            $em = $this->getDoctrine()->getManager();

            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_list');
        }
        $twigParams = [
            'error' => $error,
            'form' => $form->createView(),
        ];
        return $this->render('NumoBundle:event:new.html.twig', $twigParams);
    }

    /**
     * Finds and displays a event entity.
     *
     * @Route("/{id}/{published}", name="event_show")
     * @Method("GET")
     */
    public function showAction($id, $published)
    {
        $error = '';
        $api = $this->get('numo.apiopenagenda');
        if ($published) {
            // --- lecture de l'évènement via json (2ème paramètre à false ci-dessous) sur OpenAgenda
            $event = $api->getEvent($id, false);
            if (false === $event) {
                $events = new OaEvent; // objet vide
                $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
            }
        } else {
            // lecture dans la database
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('NumoBundle:Event')->getEvent($id);
        }
        $twigParams = [
            'agendaSlug' => $api->getAgendaSlug(),
            'event' => $event,
// --- provisoire ---------------------------------------------------
            'author' => ['name' => 'John DOE', 'imageUrl' => 'http://localhost:8000/img/logotrans.png', 'badge' => ''], // pour test
            'user' => ['rs' => []],
// -------------------------------------------------------------------
            'error' => $error,
        ];
        return $this->render('NumoBundle:event:show.html.twig', $twigParams);
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
     * @Route("/{id}", name="event_delete")
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
