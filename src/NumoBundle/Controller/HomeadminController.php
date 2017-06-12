<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 02/06/17
 * Time: 11:14
 */

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class HomeadminController extends Controller

{
    /**
     * Accès accueil admin.
     *
     * @Route("/admin", name="admin_accueil")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render ('homeAdmin.html.twig');
    }
}