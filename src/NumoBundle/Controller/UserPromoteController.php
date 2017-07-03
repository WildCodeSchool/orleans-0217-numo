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

use NumoBundle\Repository\UserRepository;


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

//
//        $userRole = $em->getRepository('NumoBundle:User')->findByRoles($roles);
//
//        var_dump($userRole);
//        die();

//        $em=$this->getDoctrine()->getManager();
//        $repository2=$em->getRepository('NumoBundle:User');
//        $roles='ROLE_MODERATOR';
//        $users2=$repository2->findByRoles(array('roles'=>$roles));

        $users = $em->getRepository('NumoBundle:User')->findAll();

        $role = 'ROLE_MODERATOR';

        if ($users->hasRole('ROLE_MODERATOR')){
            var_dump($users);
            die('a');
        }

        if ($form->isValid() && $form->isSubmitted()) {
            $data = $form->getData();
            $role[] = $data['Roles'];
            $id = $data['Id'];

            $user = $em->getRepository('NumoBundle:User')->findOneById($id);

            $user->setRoles($role);
            $em->flush();

        }

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



}