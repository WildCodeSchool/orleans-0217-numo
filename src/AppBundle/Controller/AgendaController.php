<?php

// --- src/AppBundle/Controller/AgendaController.php ---

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\EvtDate;
use AppBundle\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EventType;
use AppBundle\Form\EvtDateType;


/**
 * @Route("/agenda")
 */
class AgendaController extends Controller
{

    /**
     * @Route("/list", name="event_list")
     */
    public function listAction()
    {
        $agenda = $this->get('app.apiagenda'); // connexion au service
        $error = '';
        // --- initialisation des parametres de lecture de la liste des evenements
        $options = [
            'offset' => 0,
            'limit' => 10,
            'lang' => 'fr',
        ];
        // --- lecture de la liste
        $events = $agenda->getEventList($options);
        if (false === $events) {
            $events = [];
            $error = '(' . $agenda->getErrorCode() . ') ' . $agenda->getError;
        }
        // --- affichage
        $params = [
            'agendaSlug' => $agenda->getSlug(),
            'events' => $events,
            'error' => $error,
        ];
        return $this->render('agenda/eventList.html.twig', $params);
    }

    /**
     * @Route("/view/{uid}", name="event_view")
     */
    public function viewAction($uid)
    {
        $agenda = $this->get('app.apiagenda'); // connexion au service
        $error = '';
        $event = $agenda->getEvent($uid);
        if (false === $event) {
            $event = null;
            $error = '(' . $agenda->getErrorCode() . ') ' . $agenda->getError();
        }
        /*
        $event = [];
        $error = 'La lecture d\'un évènement ne fonctionne pas encore';
        */
        $params = [
            'event' => $event,
            'error' => $error,
        ];
        return $this->render('agenda/eventView.html.twig', $params);
    }

    /**
     * @Route("/add", name="event_add")
     */
    public function addAction(Request $request)
    {
        $error = '';
        $event = new Event();
        $location0 = new Location();
        $evtDate0 = new EvtDate();
        $location0->getDates()->add($evtDate0);
        $event->getLocations()->add($location0);
//        $evtdate = new EvtDate();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


var_dump($event);die();

            // --- enregistrement de l'evenement
            $agenda = $this->get('app.apiagenda'); // initialisation du service
            // ...


// --- provisoire pour test ---------------------------------------------------------------------------------
            $numTest = 10;


            $dt = new EvtDate;
                $dt->setEvtDate('2017-06-01');
                $dt->setTimeStart('18:00:00');
                $dt->setTimeEnd('22:00:00');
            $loc = new Location;
                $loc->setPlacename("Test $numTest");
                $loc->setLatitude('47.8938701');
                $loc->setLongitude('1.8941995');
                $loc->setAddress("1 Avenue du Champ de Mars, 45100 Orléans, France");
                $loc->setDates([$dt]);
                $loc->setTicketLink('');
                $loc->setPricingInfo("Politique de prix du test $numTest");
            $evt = new Event;
                $evt->setTitle("Evt test $numTest");
                $evt->setDescription('Evènement du test 1');
                $evt->setFreeText("Description plus longue de l'évènement du test $numTest");
                $evt->setTags("test, ecriture");
                $evt->setLocations([$loc]);
            $event = $evt;
// --- fin du provisoire ------------------------------------------------------------------------------------

            if (false === $agenda->writeEvent($event)) {
                $error = '(' . $agenda->getErrorCode() . ') ' . $agenda->getError();
            } else {
                return $this->redirectToRoute('event_list');
            }
        }

        // --- affichage du formulaire (si premier affichage ou formulaire invalide)
        $params = [
            'event' => $event,
            'error' => $error,
            'form' => $form->createView(),
        ];
        return $this->render('agenda/eventAdd.html.twig', $params);
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
        return $this->render('agenda/eventEdit.html.twig', $params);
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
        return $this->render('agenda/eventDelete.html.twig', $params);
    }
}