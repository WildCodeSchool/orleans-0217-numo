<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\PageContent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pagecontent controller.
 *
 * @Route("pagecontent")
 */
class PageContentController extends Controller
{
    /**
     * Lists all pageContent entities.
     *
     * @Route("/", name="pagecontent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pageContents = $em->getRepository('NumoBundle:PageContent')->findAll();

        return $this->render('pagecontent/index.html.twig', array(
            'pageContents' => $pageContents,
        ));
    }

    /**
     * Creates a new pageContent entity.
     *
     * @Route("/new", name="pagecontent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pageContent = new Pagecontent();
        $form = $this->createForm('NumoBundle\Form\PageContentType', $pageContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageContent);
            $em->flush();

            return $this->redirectToRoute('pagecontent_show', array('id' => $pageContent->getId()));
        }

        return $this->render('pagecontent/new.html.twig', array(
            'pageContent' => $pageContent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pageContent entity.
     *
     * @Route("/{id}", name="pagecontent_show")
     * @Method("GET")
     */
    public function showAction(PageContent $pageContent)
    {
        $deleteForm = $this->createDeleteForm($pageContent);

        return $this->render('pagecontent/show.html.twig', array(
            'pageContent' => $pageContent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pageContent entity.
     *
     * @Route("/{id}/edit", name="pagecontent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PageContent $pageContent)
    {
        $deleteForm = $this->createDeleteForm($pageContent);
        $editForm = $this->createForm('NumoBundle\Form\PageContentType', $pageContent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pagecontent_edit', array('id' => $pageContent->getId()));
        }

        return $this->render('pagecontent/edit.html.twig', array(
            'pageContent' => $pageContent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pageContent entity.
     *
     * @Route("/{id}", name="pagecontent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PageContent $pageContent)
    {
        $form = $this->createDeleteForm($pageContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pageContent);
            $em->flush();
        }

        return $this->redirectToRoute('pagecontent_index');
    }

    /**
     * Creates a form to delete a pageContent entity.
     *
     * @param PageContent $pageContent The pageContent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PageContent $pageContent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pagecontent_delete', array('id' => $pageContent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
