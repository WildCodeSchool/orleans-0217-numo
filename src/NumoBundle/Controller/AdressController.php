<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Adress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Adress controller.
 *
 * @Route("adress")
 */
class AdressController extends Controller
{
    /**
     * Lists all adress entities.
     *
     * @Route("/", name="adress_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adresses = $em->getRepository('NumoBundle:Adress')->findAll();

        return $this->render('adress/index.html.twig', array(
            'adresses' => $adresses,
        ));
    }

    /**
     * Creates a new adress entity.
     *
     * @Route("/new", name="adress_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $adress = new Adress();
        $form = $this->createForm('NumoBundle\Form\AdressType', $adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adress);
            $em->flush();

            return $this->redirectToRoute('adress_show', array('id' => $adress->getId()));
        }

        return $this->render('adress/new.html.twig', array(
            'adress' => $adress,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a adress entity.
     *
     * @Route("/{id}", name="adress_show")
     * @Method("GET")
     */
    public function showAction(Adress $adress)
    {
        $deleteForm = $this->createDeleteForm($adress);

        return $this->render('adress/show.html.twig', array(
            'adress' => $adress,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing adress entity.
     *
     * @Route("/{id}/edit", name="adress_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Adress $adress)
    {
        $deleteForm = $this->createDeleteForm($adress);
        $editForm = $this->createForm('NumoBundle\Form\AdressType', $adress);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adress_edit', array('id' => $adress->getId()));
        }

        return $this->render('adress/edit.html.twig', array(
            'adress' => $adress,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a adress entity.
     *
     * @Route("/{id}", name="adress_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Adress $adress)
    {
        $form = $this->createDeleteForm($adress);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adress);
            $em->flush();
        }

        return $this->redirectToRoute('adress_index');
    }

    /**
     * Creates a form to delete a adress entity.
     *
     * @param Adress $adress The adress entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Adress $adress)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adress_delete', array('id' => $adress->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
