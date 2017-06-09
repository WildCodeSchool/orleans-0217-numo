<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;
use NumoBundle\Entity\EvtDate;
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
     * @var
     * accès ORM Doctrine
     */
    private $em;

    /**
     * @var
     * accès service lecture/écriture OpenAgenda
     */
    private $api;

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     * initialisation accès Doctrine
     */
    private function getEm()
    {
        if ( !isset($this->em) ) {
            // On appelle Doctrine
            $this->em = $this->getDoctrine()->getManager();
        }
        return $this->em;
    }

    /**
     * @return object
     * initialisation service lecture/écriture OpenAgenda
     */
    private function getApi()
    {
        if ( !isset($this->api) ) {
            // On appelle l'API OpenAgenda (connexion au service)
            $this->api = $this->get('numo.apiopenagenda');
        }
        return $this->api;
    }


    /**
     * Lists all event entities.
     *
     * @Route("/list", name="event_list")
     * @Method("GET")
     * -- Liste les évènements -------------------------------------------------------------------------------------
     *      - par défaut : liste tous les évènements publiés et à venir (provenance OpenAgenda)
     *      - via sélecteurs :
     *          - (case à cocher) ajout à la liste des évènements non publiés (base locale)
     *              la case à cocher n'apparait que si 1°) l'utilisateur est authentifié, 2°) est administrateur ou
     *              modérateur ou auteur ayant des évènements non publiés (brouillon ou en attente de publication)
     *              Note : si auteur, seuls SES évènements non publiés sont ajoutés à la liste
     *          - sélecteur de période (date de début et date de fin - Note : dates passées possibles)
     *              seuls les évènement ayant au moins une date entrant dans la plage seront affichés
     *          - sélecteur de catégories *** a revoir <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
     *          - champ libre mots-clé (recherche dans le champ "tags" des evenements
     *      Note : les sélecteurs sont cumulables
     * -------------------------------------------------------------------------------------------------------------
     */
    public function listAction(Request $request)
    {
        $error = $startDate = $endDate = '';
        // --- initialisation des parametres de lecture par defaut de la liste des evenements
        $options = [
            'search[passed]' => 0,  // pas de sélection des évènements passés
            'offset' => 0,          // début de la liste
            'limit' => 10,          // nombre d'éléments retournés
        ];

        // --- lecture des parametres GET pour prise en compte des selecteurs
        if (isset($_GET['startdate']) && isset($_GET['enddate'])) {
            $startDate = $_GET['startdate'];
            $options['oaq[from]'] = $startDate;
            $endDate = $_GET['enddate'];
            $options['oaq[to]'] = $endDate;
            $options['search[passed]'] = 1;
        }
        if (isset($_GET['passed'])) {
            $options['search[passed]'] = $_GET['passed'];
        }
        if (isset($_GET['id'])) {
            $options['oaq[uids][]'] = $_GET['id'];
        }
        // ... autre(s) parametre(s) GET


        // --- lecture de la liste OpenAgenda
        $events = $this->getApi()->getEventList($options, false);
        if (false === $events) {
            $events = [];
            $error = '(' . $this->getApi()->getErrorCode() . ') ' . $this->getApi()->getError();
        }
        if (isset($_GET['await'])) {
            // --- on ajoute à la liste les enregistrements de la base locale
            // On passe en paramètre le id user (pour afficher seulement ses events en attente,
            // ou tous les events en attente si le user est manager ou admin.
            $dbEvents = $this->getEm()->getRepository('NumoBundle:Event')->getEventList($this->getUser());
        } else {
            $dbEvents = [];
        }

        // --- affichage
        $twigParams = [
            'agendaSlug' => $this->getApi()->getAgendaSlug(),
            'events' => $events,
            'dbEvents' => $dbEvents,
            'error' => $error,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
        $event->getEvtDates()->add($evtDate0);
        $form = $this->createForm('NumoBundle\Form\EventType', $event);
        $form->handleRequest($request);
//
        if ($form->isSubmitted() && $form->isValid()) {




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
        if ($published) {
            // --- lecture de l'évènement via json (2ème paramètre à false ci-dessous) sur OpenAgenda
            $event = $this->getApi()->getEvent($id, false);
            if (false === $event) {
                $events = new OaEvent; // objet vide
                $error = '(' . $this->getApi()->getErrorCode() . ') ' . $this->getApi()->getError();
            }
        } else {
            // lecture dans la database
            $event = $this->getEm()->getRepository('NumoBundle:Event')->getEvent($id);
        }
        $twigParams = [
            'agendaSlug' => $this->getApi()->getAgendaSlug(),
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
//        $deleteForm = $this->createDeleteForm($event);
//        $editForm = $this->createForm('NumoBundle\Form\EventType', $event);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('event_edit', array('id' => $event->getId()));
//        }
//
//        return $this->render('event/edit.html.twig', array(
//            'event' => $event,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
    }

    /**
     * Deletes a event entity.
     *
     * @Route("/{id}", name="event_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Event $event)
    {
//        $form = $this->createDeleteForm($event);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($event);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('event_index');
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
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
    }
}
