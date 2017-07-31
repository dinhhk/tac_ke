<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Bill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Bill controller.
 *
 */
class BillController extends Controller
{
    /**
     * Lists all bill entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bills = $em->getRepository('AdminBundle:Bill')->findAll();

        return $this->render('AdminBundle:Bill:index.html.twig', array(
            'bills' => $bills,
        ));
    }

    /**
     * Creates a new bill entity.
     *
     */
    public function newAction(Request $request)
    {
        $bill = new Bill();
        $form = $this->createForm('AdminBundle\Form\BillType', $bill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();

            return $this->redirectToRoute('admin_bill_edit', array('id' => $bill->getId()));
        }

        return $this->render('AdminBundle:Bill:new.html.twig', array(
            'bill' => $bill,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bill entity.
     *
     */
    public function showAction(Bill $bill)
    {
        $deleteForm = $this->createDeleteForm($bill);

        return $this->render('AdminBundle:Bill:show.html.twig', array(
            'bill' => $bill,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bill entity.
     *
     */
    public function editAction(Request $request, Bill $bill)
    {
        $deleteForm = $this->createDeleteForm($bill);
        $editForm = $this->createForm('AdminBundle\Form\BillType', $bill);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_bill_edit', array('id' => $bill->getId()));
        }

        return $this->render('AdminBundle:Bill:edit.html.twig', array(
            'bill' => $bill,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bill entity.
     *
     */
    public function deleteAction(Request $request, Bill $bill)
    {
        $form = $this->createDeleteForm($bill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bill);
            $em->flush();
        }

        return $this->redirectToRoute('admin_bill_index');
    }

    /**
     * Creates a form to delete a bill entity.
     *
     * @param Bill $bill The bill entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bill $bill)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_bill_delete', array('id' => $bill->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
