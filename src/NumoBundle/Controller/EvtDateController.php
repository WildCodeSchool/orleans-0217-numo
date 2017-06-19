<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\EvtDate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Evtdate controller.
 *
 * @Route("evtdate")
 */
class EvtDateController extends Controller
{
    /**
     * Lists all evtDate entities.
     *
     * @Route("/", name="evtdate_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evtDates = $em->getRepository('NumoBundle:EvtDate')->findAll();

        return $this->render('evtdate/index.html.twig', array(
            'evtDates' => $evtDates,
        ));
    }

    /**
     * Creates a new evtDate entity.
     *
     * @Route("/new", name="evtdate_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evtDate = new Evtdate();
        $form = $this->createForm('NumoBundle\Form\EvtDateType', $evtDate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evtDate);
            $em->flush();

            return $this->redirectToRoute('evtdate_show', array('id' => $evtDate->getId()));
        }

        return $this->render('evtdate/new.html.twig', array(
            'evtDate' => $evtDate,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a evtDate entity.
     *
     * @Route("/{id}", name="evtdate_show")
     * @Method("GET")
     */
    public function showAction(EvtDate $evtDate)
    {
        $deleteForm = $this->createDeleteForm($evtDate);

        return $this->render('evtdate/show.html.twig', array(
            'evtDate' => $evtDate,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing evtDate entity.
     *
     * @Route("/{id}/edit", name="evtdate_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EvtDate $evtDate)
    {
        $deleteForm = $this->createDeleteForm($evtDate);
        $editForm = $this->createForm('NumoBundle\Form\EvtDateType', $evtDate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evtdate_edit', array(
                'id' => $evtDate->getId()
            ));
        }

        return $this->render('evtdate/edit.html.twig', array(
            'evtDate' => $evtDate,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a evtDate entity.
     *
     * @Route("/{id}", name="evtdate_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EvtDate $evtDate)
    {
        $form = $this->createDeleteForm($evtDate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evtDate);
            $em->flush();
        }

        return $this->redirectToRoute('evtdate_index');
    }

    /**
     * Creates a form to delete a evtDate entity.
     *
     * @param EvtDate $evtDate The evtDate entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EvtDate $evtDate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evtdate_delete', array('id' => $evtDate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
