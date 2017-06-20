<?php

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AssociationController extends Controller
{
    /**
     * @Route("/association", name="association")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $company= $em->getRepository('NumoBundle:Company')->find(1);

        return $this->render('NumoBundle:site:company.html.twig', [
            'company' => $company
        ]);
    }
}
