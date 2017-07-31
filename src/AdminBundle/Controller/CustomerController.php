<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Customer controller.
 *
 */
class CustomerController extends Controller
{
    /**
     * Lists all customer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository('AdminBundle:Customer')->findAll();

        return $this->render('AdminBundle:Customer:index.html.twig', array(
            'customers' => $customers,
        ));
    }

    /**
     * Creates a new customer entity.
     *
     */
    public function newAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm('AdminBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A customer have added successfully.');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('AdminBundle:Customer:new.html.twig', array(
            'customer' => $customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a customer entity.
     *
     */
    public function showAction(Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);

        return $this->render('AdminBundle:Customer:show.html.twig', array(
            'customer' => $customer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing customer entity.
     *
     */
    public function editAction(Request $request, Customer $customer)
    {
        $deleteForm = $this->createDeleteForm($customer);
        $editForm = $this->createForm('AdminBundle\Form\CustomerType', $customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A customer have updated successfully.');

            return $this->redirectToRoute('customer_index');
        }

        return $this->render('AdminBundle:Customer:edit.html.twig', array(
            'customer' => $customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a customer entity.
     *
     */
    public function deleteAction(Request $request, Customer $customer)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($customer);
        $form->handleRequest($request);

        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($customer);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A customer have deleted successfully.');
            }
        } else {
            $em->remove($customer);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A product have deleted successfully.');
        }
        
        return $this->redirectToRoute('customer_index');
    }

    /**
     * Creates a form to delete a customer entity.
     *
     * @param Customer $customer The customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Customer $customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
