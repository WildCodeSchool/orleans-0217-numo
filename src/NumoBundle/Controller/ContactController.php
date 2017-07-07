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
        $company= $em->getRepository('NumoBundle:Company')->find(1);

        if($form->isSubmitted() && $form->isValid()) {

            $this->addFlash(
                'messageContact',
                'Votre mail de contact a bien été envoyé'
            );

            $commentaire = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setTo($company->getContactEmail())
                ->setFrom($contact ->getEmail())
                ->setBody($contact->getCommentaire());

            $this->get('mailer')->send($commentaire);
            return $this-> redirectToRoute('contact');
        }

        if($form->isSubmitted() != $form->isValid() ){

            $this->addFlash(
                'messageNoContact',
                'Une erreur est survenue lors de votre envoi de mail'
            );
        }

        return $this->render('NumoBundle:site:pageContact.html.twig', [
            'form'=>$form->createView(),
            'company' => $company,
        ]);
    }




}
