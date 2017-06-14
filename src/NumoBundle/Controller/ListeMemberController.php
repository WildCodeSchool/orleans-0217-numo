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

        return $this->render('NumoBundle:site:member.html.twig', array(
            'members' => $members
        ));
    }

    /**
     * Finds and displays a user entity.
     * @Route("/profilMember/{id}", name="profilMember")
     */
    public function ShowProfilMenber($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('NumoBundle:User')->find($id);
        return $this->render('NumoBundle:site:profilMember.html.twig', array(
            'user' => $user,
        ));
    }



}
