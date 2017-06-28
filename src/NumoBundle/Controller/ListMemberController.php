<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Event;
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

        return $this->render('NumoBundle:site:member.html.twig', [
            'members' => $members
        ]);
    }

    /**
     * Finds and displays a user entity.
     * @Route("/profilMember/{id}", name="profilMember")
     */
    public function showProfilMember(User $user)
    {
//        $em = $this->getDoctrine()->getManager();
//        $events= $em->getRepository('NumoBundle:Event')->findBy($id);

        return $this->render('NumoBundle:site:profilMember.html.twig', [
            'user' => $user,
        ]);
    }



}
