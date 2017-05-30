<?php

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AssociationController extends Controller
{
    /**
     * @Route("/presentation")
     */
    public function indexAction()
    {

        return $this->render('NumoBundle:Site:compagny.html.twig');
    }
}
