<?php

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ListeMemberController extends Controller
{
    /**
     * @Route("/members", name="members")
     */
    public function ShowlistMenber()
    {
        $em = $this->getDoctrine()->getManager();
        $members= $em->getRepository('NumoBundle:User')->findAll();

        return $this->render('NumoBundle:Site:member.html.twig', array(
            'members' => $members
        ));
    }

}
