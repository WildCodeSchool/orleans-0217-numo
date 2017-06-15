<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Contact;
use NumoBundle\Entity\Company;
use NumoBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/contact")
 */


class ContactController extends DefaultController
{
    /**
     * @Route("/", name="contact")
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $company= $em->getRepository('NumoBundle:Company')->findAll()[0];

        if($form->isSubmitted() && $form->isValid()) {

            $commentaire = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setTo($company->getContactEmail())
                ->setFrom($contact ->getEmail())
                ->setBody($contact->getCommentaire());

            $this->get('mailer')->send($commentaire);
            return $this-> redirectToRoute('contact');
        }


        return $this->render('NumoBundle:site:pageContact.html.twig', array('form'=>$form->createView(),
        'company' => $company ));
    }




}
