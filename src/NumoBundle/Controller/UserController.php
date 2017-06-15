<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("/promote")
 */
class UserController extends Controller
{
    /**
     * Lists all Users.
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('test.html.twig', array(
            'users' => $users,
        ));
    }
    /**
     *@Route("/{id}", name="promote")
     *
     */
    public function promoteAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->addRole('ROLE_ADHERENT');
        $em->flush();

        return $this->redirectToRoute('fos_user_profile_show');
    }



}

