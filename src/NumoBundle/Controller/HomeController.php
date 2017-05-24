<?php
/**
 * Created by PhpStorm.
 * User: wilder9
 * Date: 24/05/17
 * Time: 14:45
 */

namespace NumoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class HomeController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('NumoBundle:Site:home.html.twig');
    }
}