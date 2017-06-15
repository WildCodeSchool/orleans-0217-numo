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

        $contents= $em->getRepository('NumoBundle:PageContent')->find($id=1);
        $company= $em->getRepository('NumoBundle:Company')->find($id=1);

        return $this->render('NumoBundle:site:company.html.twig', array(
            'contents' => $contents,
            'company' => $company
        ));
    }
}
