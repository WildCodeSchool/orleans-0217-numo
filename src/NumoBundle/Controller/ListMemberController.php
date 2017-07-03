<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Published;
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
        $members = $em->getRepository('NumoBundle:User')->findAll();

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
        $api = $this->get('numo.apiopenagenda');
        $events = $api->getEvent($id);
        $em = $this->getDoctrine()->getManager();
        $published = $em->getRepository('NumoBundle:Published')->findByAuthor($user);

        $uids = [];
        foreach ($published as $pub) {
            $uids[] = $pub->getUid();

        }
        return $this->render('NumoBundle:site:profilMember.html.twig', [
            'user' => $user,
            'uids' => $uids,
            'events' => $events,
        ]);
    }

}




