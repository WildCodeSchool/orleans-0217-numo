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
     * Displays a form to edit an existing Users.
     *@Route("/", name="promote")
     */
    public function editAction(Request $request)
    {

        $id = $this->getUser()->getId();
        $editForm = $this->createForm('NumoBundle\Form\UserType', $id);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('fos_user_profile_show');
        }
        ;
    }

}

