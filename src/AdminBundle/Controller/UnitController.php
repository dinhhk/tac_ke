<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Unit controller.
 *
 */
class UnitController extends Controller
{
    /**
     * Lists all unit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $units = $em->getRepository('AdminBundle:Unit')->findAll();

        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('unit_delete', array('id' => ':USER_ID')))
            ->setMethod('DELETE')
            ->getForm();

        return $this->render('AdminBundle:Unit:index.html.twig', array(
            'units' => $units,
            'delete_form' => $delete_form->createView()
        ));
    }

    /**
     * Creates a new unit entity.
     *
     */
    public function newAction(Request $request)
    {
        $unit = new Unit();
        $form = $this->createForm('AdminBundle\Form\UnitType', $unit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A unit have added successfully.');

            return $this->redirectToRoute('unit_index', array('id' => $unit->getId()));
        }

        return $this->render('AdminBundle:Unit:new.html.twig', array(
            'unit' => $unit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a unit entity.
     *
     */
    public function showAction(Unit $unit)
    {
        $deleteForm = $this->createDeleteForm($unit);

        return $this->render('AdminBundle:Unit:show.html.twig', array(
            'unit' => $unit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing unit entity.
     *
     */
    public function editAction(Request $request, Unit $unit)
    {
        $deleteForm = $this->createDeleteForm($unit);
        $editForm = $this->createForm('AdminBundle\Form\UnitType', $unit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A unit have updated successfully.');

            return $this->redirectToRoute('unit_index', array('id' => $unit->getId()));
        }

        return $this->render('AdminBundle:Unit:edit.html.twig', array(
            'unit' => $unit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a unit entity.
     *
     */
    public function deleteAction(Request $request, Unit $unit)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($unit);
        $form->handleRequest($request);
        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($unit);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A unit have deleted successfully.');
            }    
        } else {
            $em->remove($unit);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A unit have deleted successfully.');
        }

        return $this->redirectToRoute('unit_index');
    }

    /**
     * Creates a form to delete a unit entity.
     *
     * @param Unit $unit The unit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unit $unit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unit_delete', array('id' => $unit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
