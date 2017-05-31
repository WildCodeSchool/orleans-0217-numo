<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Contact;
use NumoBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends DefaultController
{




    /**
     * @Route("/contact", name="contact")
     */

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $commentaire = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setTo('duri.teamwild@gmail.com')
                ->setFrom($contact ->getEmail())
                ->setBody($contact->getCommentaire());

            $this->get('mailer')->send($commentaire);
            return $this-> redirectToRoute('contact');
        }
//        $nom = $request->request->get('nom'); $_POST['"
//        $email = $request->request->get('email');
//        $sujet = $request->request->get('sujet');
//        $commentaire = $request->request->get('commentaire');
//        $data = "";
//        if($request->request->get('contact_submit')){
//
//
//
//            $data = "Thank you: $nom";
//
//        }
        return $this->render('NumoBundle:Site:pageContact.html.twig', array('form'=>$form->createView()));
    }



}
