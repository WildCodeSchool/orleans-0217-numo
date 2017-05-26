<?php

// --- src/AppBundle/Controller/AgendaController.php ---

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/agenda")
 */
class AgendaController extends Controller
{

    /**
     * @Route("/test", name="test_agenda")
     */
    public function testAction()
    {
        $agenda = $this->get('app.apiagenda');
        $options = [
            'offset' => 0,
            'limit' => 5,
            'lang' => 'fr',
        ];
        $params = [
            'agendaSlug' => $agenda->getSlug(),
            'events' => $agenda->getEventList($options),
        ];
        return $this->render('agenda/eventList.html.twig', $params);


    }

}