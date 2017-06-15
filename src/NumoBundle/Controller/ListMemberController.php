<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ListMemberController extends Controller
{
    /**
     * @Route("/members", name="members")
     */
    public function showListMember()
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
    public function showProfilMember(User $user)
    {
        return $this->render('NumoBundle:site:profilMember.html.twig', array(
            'user' => $user,
        ));
    }



}
