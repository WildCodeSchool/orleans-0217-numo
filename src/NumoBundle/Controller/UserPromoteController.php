<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 12/06/17
 * Time: 16:18
 */

namespace NumoBundle\Controller;

use NumoBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * User Promote controller.
 *
 * @Route("memberstatus")
 */

class UserPromoteController extends Controller
{
    /**
     * Lists all pageContent entities.
     *
     * @Route("/", name="memberstatus_index")
     * @Method({"POST", "GET"})
     */

    public function indexAction(Request $request)
    {
        $form = $this->createForm('NumoBundle\Form\PromoteType');
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isValid() && $form->isSubmitted()) {
            $data = $form->getData();
            $role[] = $data['Roles'];
            $id = $data['Id'];

            $user = $em->getRepository('NumoBundle:User')->findOneById($id);

            $user->setRoles($role);
            $em->flush();

        }

        $users = $em->getRepository('NumoBundle:User')->findAll();

        return $this->render('userpromote/index.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}", name="membertrust")
     */
    public function trustAction(User $user)
    {
        if ($user->getTrust() === 0){
            $user->setTrust(1);
        } else {
            $user->setTrust(0);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('memberstatus_index');
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}", name="moderatorMail")
     */
    public function moderatorMail(User $user)
    {
        if ($user->getTrust() === 0){
            $user->setTrust(1);
        } else {
            $user->setTrust(0);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('memberstatus_index');
    }



}