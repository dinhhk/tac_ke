<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\ImportDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Importdetail controller.
 *
 */
class ImportDetailController extends Controller
{
    /**
     * Lists all importDetail entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $importDetails = $em->getRepository('AdminBundle:ImportDetail')->findAll();

        return $this->render('AdminBundle:ImportDetail:index.html.twig', array(
            'importDetails' => $importDetails,
        ));
    }

    /**
     * Creates a new importDetail entity.
     *
     */
    public function newAction(Request $request)
    {
        $importDetail = new Importdetail();
        $form = $this->createForm('AdminBundle\Form\ImportDetailType', $importDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($importDetail);
            $em->flush();

            return $this->redirectToRoute('import_detail_index');
        }

        return $this->render('AdminBundle:ImportDetail:new.html.twig', array(
            'importDetail' => $importDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a importDetail entity.
     *
     */
    public function showAction(ImportDetail $importDetail)
    {
        $deleteForm = $this->createDeleteForm($importDetail);

        return $this->render('AdminBundle:ImportDetail:show.html.twig', array(
            'importDetail' => $importDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing importDetail entity.
     *
     */
    public function editAction(Request $request, ImportDetail $importDetail)
    {
        $deleteForm = $this->createDeleteForm($importDetail);
        $editForm = $this->createForm('AdminBundle\Form\ImportDetailType', $importDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('import_detail_index');
        }

        return $this->render('AdminBundle:ImportDetail:edit.html.twig', array(
            'importDetail' => $importDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a importDetail entity.
     *
     */
    public function deleteAction(Request $request, ImportDetail $importDetail)
    {
        $form = $this->createDeleteForm($importDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($importDetail);
            $em->flush();
            if($request->isXMLHttpRequest())
            {
                return new Response(
                    json_encode(array('removed' => 1, 'message' => 'Import detail has been deleted.')),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
        }

        return $this->redirectToRoute('import_detail_index');
    }

    /**
     * Creates a form to delete a importDetail entity.
     *
     * @param ImportDetail $importDetail The importDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImportDetail $importDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('import_detail_delete', array('id' => $importDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
