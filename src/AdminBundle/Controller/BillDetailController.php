<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\BillDetail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Billdetail controller.
 *
 */
class BillDetailController extends Controller
{
    /**
     * Lists all billDetail entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $billDetails = $em->getRepository('AdminBundle:BillDetail')->findAll();

        return $this->render('AdminBundle:BillDetail:index.html.twig', array(
            'billDetails' => $billDetails,
        ));
    }

    /**
     * Creates a new billDetail entity.
     *
     */
    public function newAction(Request $request)
    {
        $billDetail = new Billdetail();
        $form = $this->createForm('AdminBundle\Form\BillDetailType', $billDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($billDetail);
            $em->flush();

            return $this->redirectToRoute('bill_detail_show', array('id' => $billDetail->getId()));
        }

        return $this->render('AdminBundle:BillDetail:new.html.twig', array(
            'billDetail' => $billDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a billDetail entity.
     *
     */
    public function showAction(BillDetail $billDetail)
    {
        $deleteForm = $this->createDeleteForm($billDetail);

        return $this->render('AdminBundle:BillDetail:show.html.twig', array(
            'billDetail' => $billDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing billDetail entity.
     *
     */
    public function editAction(Request $request, BillDetail $billDetail)
    {
        $deleteForm = $this->createDeleteForm($billDetail);
        $editForm = $this->createForm('AdminBundle\Form\BillDetailType', $billDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bill_detail_edit', array('id' => $billDetail->getId()));
        }

        return $this->render('AdminBundle:BillDetail:edit.html.twig', array(
            'billDetail' => $billDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a billDetail entity.
     *
     */
    public function deleteAction(Request $request, BillDetail $billDetail)
    {
        $form = $this->createDeleteForm($billDetail);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($billDetail);
            $em->flush();
                
            $request->getSession()
                ->getFlashBag()
                ->add('success', "A bill detail have <strong>deleted</strong> successfully.");

            if($request->isXMLHttpRequest())
            {
                $bill_id = $request->get('billDetail')->getBill()->getId();
                $total = $this->container->get('admin.util.bill_util')->updateTotalPrice($bill_id);
                return new Response(
                    json_encode(array('removed' => 1, 'message' => 'Bill detail has been deleted.', 'total' => $total)),
                    200,
                    array('Content-Type' => 'application/json')
                );
            }
        }

        return $this->redirectToRoute('bill_detail_index');
    }

    /**
     * Creates a form to delete a billDetail entity.
     *
     * @param BillDetail $billDetail The billDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BillDetail $billDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bill_detail_delete', array('id' => $billDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
