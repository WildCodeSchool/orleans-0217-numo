<?php

// --- src/NumoBundle/Controller/EventController.php ---

namespace NumoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/event")
 */
class EventController extends Controller
{

    private $em;
    private $api;

    private function getEm()
    {
        if ( !isset($this->em) ) {
            // On appelle Doctrine
            $this->em = $this->getDoctrine()->getManager();
        }
        return $this->em;
    }

    private function getApi()
    {
        if ( !isset($this->api) ) {
            // On appelle l'API OpenAgenda
            $this->api = $this->get('numo.apiopenagenda'); // connexion au service
        }
        return $this->api;
    }


    /**
     * @Route("/list", name="event_list")
     */
    public function listAction()
    {
        $error = '';
        // --- initialisation des parametres de lecture de la liste des evenements (***** provisoire *****)
        $options = [
            'offset' => 0,
            'limit' => 10,
            'lang' => 'fr',
        ];
        // --- lecture de la liste
        $events = $this->getApi()->getEventList($options);
        if (false === $events) {
            $events = [];
            $error = '(' . $this->getApi()->getErrorCode() . ') ' . $this->getApi()->getError();
        }
        // --- affichage
        $params = [
            'agendaSlug' => $this->getApi()->getAgendaSlug(),
            'events' => $events,
            'error' => $error,
        ];
        return $this->render('NumoBundle:events:eventList.html.twig', $params);
    }

    /**
     * @Route("/view/{uid}", name="event_view")
     */
    public function viewAction($uid)
    {
        $error = '';
        $event = $this->getApi()->getEvent($uid);
        if (false === $event) {
            $event = null;
            $error = '(' . $this->getApi()->getErrorCode() . ') ' . $this->getApi()->getError();
        }
        $params = [
            'agendaSlug' => $this->getApi()->getAgendaSlug(),
            'event' => $event,
            'error' => $error,
        ];
        return $this->render('NumoBundle:events:eventView.html.twig', $params);
    }

    /**
     * @Route("/add", name="event_add")
     */
    public function addAction(Request $request)
    {
        $event = [];
        $error = 'L\'ajout d\'un évènement ne fonctionne pas encore';
        $params = [
            'event' => $event,
            'error' => $error,
        ];
        return $this->render('NumoBundle:events:eventAdd.html.twig', $params);
    }

    /**
     * @Route("/edit/{$id}", name="event_edit")
     */
    public function editAction($id)
    {
        $event = [];
        $error = 'L\'édition d\'un évènement ne fonctionne pas encore';
        $params = [
            'event' => $event,
            'error' => $error,
        ];
        return $this->render('NumoBundle:events:eventEdit.html.twig', $params);
    }

    /**
     * @Route("/delete/{$id}", name="event_delete")
     */
    public function deleteAction($id)
    {
        $event = [];
        $error = 'La suppression d\'un évènement ne fonctionne pas encore';
        $params = [
            'event' => $event,
            'error' => $error,
        ];
        return $this->render('NumoBundle:events:eventDelete.html.twig', $params);
    }


}