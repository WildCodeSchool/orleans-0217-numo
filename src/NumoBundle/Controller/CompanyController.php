<?php

namespace NumoBundle\Controller;

use NumoBundle\Entity\Company;
use NumoBundle\Form\CompanyType;
use NumoBundle\Services\UserUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Company controller.
 *
 * @Route("admin/company")
 */
class CompanyController extends Controller
{
    /**
     * Lists all company entities.
     *
     * @Route("/", name="company_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $companies = $em->getRepository('NumoBundle:Company')->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * Creates a new company entity.
     *
     * @Route("/new", name="company_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render('company/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a company entity.
     *
     * @Route("/{id}", name="company_show")
     * @Method("GET")
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company);

        return $this->render('company/show.html.twig', [
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing company entity.
     *
     * @Route("/{id}/edit", name="company_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Company $company)
    {

        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm('NumoBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();



            return $this->redirectToRoute('company_edit', ['id' => $company->getId()]);
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a company entity.
     *
     * @Route("/{id}", name="company_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($company);
            $em->flush();
        }

        return $this->redirectToRoute('company_index');
    }

    /**
     * Deletes an image in company entity.
     *
     * @Route("/{id}/delete_image", name="company_delete_image")
     * @Method({"GET", "POST"})
     */
    public function deleteImageAction(Company $company)

    {
        $path = $company->getImageUrl();
        $em = $this->getDoctrine()->getManager();
        $company->setImageUrl('');
        $em->flush();
        // effacement du fichier
        unlink($this->getParameter('upload_directory') . '/' .
            $path);
        return $this->redirectToRoute('company_edit', array('id' => $company->getId()));
    }

    /**
     * Deletes a pdf in company entity.
     *
     * @Route("/{id}/delete_pdf", name="company_delete_pdf")
     * @Method({"GET", "POST"})
     */
    public function deletePdfAction (Company $company)
    {
        $path = $company->getPdf();
        $em = $this->getDoctrine()->getManager();
        $company->setPdf('');
        $em->flush();
        // effacement du fichier
        unlink($this->getParameter('upload_directory') . '/' .
            $path);
        return $this->redirectToRoute('company_edit', array('id' => $company->getId()));
    }
    /**
     * Creates a form to delete a company entity.
     *
     * @param Company $company The company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', ['id' => $company->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
