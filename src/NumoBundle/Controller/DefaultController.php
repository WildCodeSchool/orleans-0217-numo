<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $error = ''; // sera initialisée par l'api si erreur de lecture

// --- initialisation des parametres de lecture par defaut de la liste des evenements
        $options = [
            'search[passed]' => 0,
            'offset' => 0,
            'limit' => 6,
        ];

// --- lecture de la liste OpenAgenda
        $api = $this->get('numo.apiopenagenda'); // initialisation de l'accès à l'API
        $data = $api->getEventList($options, false);
        $events = $data['eventList'];
        if (false === $events) {
            $events = [];
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        }
        $em = $this->getDoctrine()->getManager();
        $partners = $em->getRepository('NumoBundle:Partner')->findAll();

// --- affichage
        return $this->render('NumoBundle:site:index.html.twig', array(
        'agendaSlug' => $api->getAgendaSlug(),
            'events' => $events,
            'error' => $error,
            'partners' => $partners,
        ));
    }


}
