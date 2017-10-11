<?php
/**
 * Created by PhpStorm.
 * User: wilder10
 * Date: 14/07/17
 * Time: 09:06
 */

namespace NumoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TestsController extends Controller
{
    /**
     * @ROUTE("/test")
     */
    public function TestAction()
    {

        $a_uid = '91057368'; // agenda uid
        $e_uid = '44566425'; // event uid

//        // --- tous les events via json
//        $url = "https://openagenda.com/agendas/$a_uid/events.json";
//        $data = json_decode(file_get_contents($url));
//        var_dump($data);

        $liste = ['debut', 'milieu', 'fin'];
        $erreur = '';
        $data = '';

//        $url = "https://openagenda.com/agendas/$a_uid/events.json?oaq[uids][]=$e_uid";
        $url = 'pouetpouet';

        try {
            $data = file_get_contents($url);
        } catch (\Exception $e) {
            $erreur = $e->getMessage();
        } finally {
            $data = json_decode($data);
            return $this->render('test/test.html.twig', ['data' => $data, 'liste' => $liste, 'erreur' => $erreur]);
        }
    }



}