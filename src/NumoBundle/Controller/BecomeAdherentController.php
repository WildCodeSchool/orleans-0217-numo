<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 12/06/17
 * Time: 14:33
 */

namespace NumoBundle\Controller;

use NumoBundle\Entity\PageContent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;




class BecomeAdherentController extends Controller
{
    /**
     * @Route("/devenezadherent", name="become_adherent")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $company = $em->getRepository('NumoBundle:Company')->find(1);

        return $this->render('NumoBundle:site:becomeAdherent.html.twig', [
            'company' => $company
        ]);
    }
}