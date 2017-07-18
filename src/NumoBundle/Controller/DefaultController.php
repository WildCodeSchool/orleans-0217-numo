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
        $error = '';

// --- initialisation des parametres de lecture par defaut de la liste des evenements
        $options = [
            'search[passed]' => 0,
            'offset' => 0,
            'limit' => 6,
        ];

// --- lecture de la liste OpenAgenda
        $api = $this->get('numo.apiopenagenda');
        $data = $api->getEventList($options);
        if (false === $data) {
            $events = [];
            $error = 'code : ' . $api->getErrorCode() . ', message : ' . $api->getError();
        } else {
            $events = $data['eventList'];
        }
        $em = $this->getDoctrine()->getManager();
        $partners = $em->getRepository('NumoBundle:Partner')->findBy(['active' => 1]);

// --- affichage
        return $this->render('NumoBundle:site:index.html.twig', [
            'agendaSlug' => $api->getAgendaSlug(),
            'events' => $events,
            'error' => $error,
            'partners' => $partners,
            'mailChimpApi' => $this->getParameter('mail_chimp_api')

        ]);
    }

    /**
     * @Route("/error/{code}/{error}", name="error_page")
     */
    public function errorAction($code = 0, $error = '')
    {
        return $this->render('NumoBundle:site:error.html.twig', ['code' => $code, 'error' => $error]);
    }

}
