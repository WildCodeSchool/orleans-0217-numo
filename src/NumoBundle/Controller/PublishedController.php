<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Company;
use NumoBundle\Entity\Published;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Published controller.
 *
 * @Route("published")
 */
class PublishedController extends Controller
{
    /**
     * Lists all published entities.
     *
     * @Route("/", name="published_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publisheds = $em->getRepository('NumoBundle:Published')->findAll();

        return $this->render('published/index.html.twig', array(
            'publisheds' => $publisheds,
        ));
    }

    /**
     * Creates a new published entity.
     *
     * @Route("/new", name="published_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $published = new Published();
        $form = $this->createForm('NumoBundle\Form\PublishedType', $published);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($published);
            $em->flush();


            return $this->redirectToRoute('published_show', array('id' => $published->getId()));
        }

        return $this->render('published/new.html.twig', array(
            'published' => $published,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a published entity.
     *
     * @Route("/{id}", name="published_show")
     * @Method("GET")
     */
    public function showAction(Published $published)
    {
        $deleteForm = $this->createDeleteForm($published);

        return $this->render('published/show.html.twig', array(
            'published' => $published,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing published entity.
     *
     * @Route("/{id}/edit", name="published_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Published $published)
    {
        $deleteForm = $this->createDeleteForm($published);
        $editForm = $this->createForm('NumoBundle\Form\PublishedType', $published);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('published_edit', array('id' => $published->getId()));
        }

        return $this->render('published/edit.html.twig', array(
            'published' => $published,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a published entity.
     *
     * @Route("/{id}", name="published_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Published $published)
    {
        $form = $this->createDeleteForm($published);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($published);
            $em->flush();
        }

        return $this->redirectToRoute('published_index');
    }

    /**
     * Creates a form to delete a published entity.
     *
     * @param Published $published The published entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Published $published)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('published_delete', array('id' => $published->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
