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
     * @Method("GET")
     */

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('NumoBundle:User')->findAll();

        return $this->render('userpromote/index.html.twig', [
            'users' => $users,
        ]);

    }
}