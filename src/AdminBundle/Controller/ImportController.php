<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Import;
use AdminBundle\Entity\ImportDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Import controller.
 *
 */
class ImportController extends Controller
{
    /**
     * Lists all import entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imports = $em->getRepository('AdminBundle:Import')->findAll();

        return $this->render('AdminBundle:Import:index.html.twig', array(
            'imports' => $imports,
        ));
    }

    /**
     * Creates a new import entity.
     *
     */
    public function newAction(Request $request)
    {
        $import = new Import();

        $form = $this->createForm('AdminBundle\Form\ImportType', $import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($import);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', "A import have <strong>added</strong> successfully.");

            return $this->redirectToRoute('import_edit', array('id' => $import->getId()));
        }

        return $this->render('AdminBundle:Import:new.html.twig', array(
            'import' => $import,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a import entity.
     *
     */
    public function showAction(Import $import)
    {
        $deleteForm = $this->createDeleteForm($import);

        return $this->render('AdminBundle:Import:show.html.twig', array(
            'import' => $import,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing import entity.
     *
     */
    public function editAction(Request $request, Import $import)
    {
        if($import->getVerified() == TRUE) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'The import was out of date.');

            return $this->redirectToRoute('import_index');
        }

        $import_details = $import->getImportDetails();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($import_details, $request->query->getInt('page', 1), 100);

        //$deleteForm = $this->createDeleteForm($import);
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('import_detail_delete', array('id' => ':IMPORT_DETAIL_ID')))
            ->setMethod('DELETE')
            ->getForm();

        $editForm = $this->createForm('AdminBundle\Form\ImportType', $import, array("pagination" => $pagination));

        if($request->request->has('add')) {
            $import->setAction('add');
        } elseif($request->request->has('update')) {
            $import->setAction('update');
        } elseif($request->request->has('verified')) {
            $import_details = $import->getImportDetails();
            if(count($import_details) == 0) {
                $request->getSession()
                ->getFlashBag()
                ->add('error', 'The import detail is empty.');

                return $this->redirectToRoute('import_edit', array('id' => $import->getId()));
            }
        
            $import->setAction('verified');
            $import->setVerified(1);
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('import_edit', array('id' => $import->getId()));
        }

        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', "A import have <strong>updated</strong> successfully.");

            return $this->redirectToRoute('import_edit', array('id' => $import->getId()));
        }


        return $this->render('AdminBundle:Import:edit.html.twig', array(
            'import' => $import,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'pagination' => $pagination
        ));
    }

    /**
     * Deletes a import entity.
     *
     */
    public function deleteAction(Request $request, Import $import)
    {
        if($import->getVerified() == TRUE) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', 'The import was out of date.');

            return $this->redirectToRoute('import_index');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($import);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($import);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', "A import have <strong>deleted</strong> successfully.");
        } else {
            $em->remove($import);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', "A import have <strong>deleted</strong> successfully.");
        }

        return $this->redirectToRoute('import_index');
    }

    /**
     * Creates a form to delete a import entity.
     *
     * @param Import $import The import entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Import $import)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('import_delete', array('id' => $import->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
