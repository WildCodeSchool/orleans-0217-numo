<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 30/05/17
 * Time: 17:20
 */

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
{

    /**
     * @Route("/adherer", name="adherer")
     */
    public function indexMember()
    {
            $em = $this->getDoctrine()->getManager();

            $content = $em->getRepository('NumoBundle:PageContent')->find(2);

            return $this->render('member.html.twig', [
                'content' => $content,
            ]);
    }
}