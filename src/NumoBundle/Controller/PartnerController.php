<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use NumoBundle\Form\PartnerType;
use NumoBundle\Services\UserUploader;

/**
 * Partner controller.
 *
 * @Route("partner")
 */
class PartnerController extends Controller
{
    /**
     * Lists all partner entities.
     *
     * @Route("/", name="partner_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partners = $em->getRepository('NumoBundle:Partner')->findAll();

        return $this->render('partner/index.html.twig', [
            'partners' => $partners,
        ]);
    }

    /**
     * Creates a new partner entity.
     *
     * @Route("/new", name="partner_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $partner = new Partner();
        $form = $this->createForm('NumoBundle\Form\PartnerType', $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('partner_show', ['id' => $partner->getId()]);
        }

        return $this->render('partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a partner entity.
     *
     * @Route("/{id}", name="partner_show")
     * @Method("GET")
     */
    public function showAction(Partner $partner)
    {
        $deleteForm = $this->createDeleteForm($partner);

        return $this->render('partner/show.html.twig', [
            'partner' => $partner,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing partner entity.
     *
     * @Route("/{id}/edit", name="partner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Partner $partner)
    {
        $deleteForm = $this->createDeleteForm($partner);
        $editForm = $this->createForm('NumoBundle\Form\PartnerType', $partner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partner_edit', ['id' => $partner->getId()]);
        }

        return $this->render('partner/edit.html.twig', [
            'partner' => $partner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a partner entity.
     *
     * @Route("/{id}", name="partner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Partner $partner)
    {
        $form = $this->createDeleteForm($partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partner);
            $em->flush();
        }

        return $this->redirectToRoute('partner_index');
    }

    /**
     * Deletes an image in partner entity.
     *
     * @Route("/{id}/delete_image", name="partner_delete_image")
     * @Method({"GET", "POST"})
     */
    public function deleteImageAction(Partner $partner)
    {
        $path = $partner->getImageUrl();
        $em = $this->getDoctrine()->getManager();
        $partner->setImageUrl('');
        $em->flush();
        // effacement du fichier
        unlink($this->getParameter('upload_directory') . '/' .
            $path);
        return $this->redirectToRoute('partner_edit', array('id' => $partner->getId()));
    }

    /**
     * Creates a form to delete a partner entity.
     *
     * @param Partner $partner The partner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partner $partner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partner_delete', ['id' => $partner->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param Partner $partner
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/active/{id}", name="partner_active")
     */
    public function ActiveAction(Partner $partner)
    {
        if ($partner->getActive() === 0){
            $partner->setActive(1);
        } else {
            $partner->setActive(0);
        }
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('partner_index');
    }
}
