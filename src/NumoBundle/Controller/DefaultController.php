<?php

namespace NumoBundle\Controller;

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
            'search[passed]' => 0,  // pas de sélection des évènements passés
            'offset' => 0,          // début de la liste
            'limit' => 6,           // nombre d'éléments retournés
        ];

// --- lecture de la liste OpenAgenda

        $api = $this->get('numo.apiopenagenda'); // initialisation de l'accès à l'API
        $events = $api->getEventList($options, false); // recuperation de la liste via json, tableau d'objets OaEvent
        if (false === $events) { // si ça a foiré, on récupère l'erreur
            $events = [];
            $error = '(' . $api->getErrorCode() . ') ' . $api->getError();
        }
// --- affichage
        $twigParams = [
            'agendaSlug' => $api->getAgendaSlug(),	// le nom de l'agenda
            'events' => $events,			// la liste des events (format OaEvents)
            'error' => $error,				// l'erreur si la lecture a foiré
        ];
        return $this->render('NumoBundle:site:index.html.twig', $twigParams);
    }


}
