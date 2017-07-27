<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Type controller.
 *
 */
class TypeController extends Controller
{
    /**
     * Lists all type entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('AdminBundle:Type')->findAll();

        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('type_delete', array('id' => ':USER_ID')))
            ->setMethod('DELETE')
            ->getForm();

        return $this->render('AdminBundle:Type:index.html.twig', array(
            'types' => $types,
            'delete_form' => $delete_form->createView()
        ));
    }

    /**
     * Creates a new type entity.
     *
     */
    public function newAction(Request $request)
    {
        $type = new Type();
        $form = $this->createForm('AdminBundle\Form\TypeType', $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A type have added successfully.');

            return $this->redirectToRoute('type_index');
        }

        return $this->render('AdminBundle:Type:new.html.twig', array(
            'type' => $type,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a type entity.
     *
     */
    public function showAction(Type $type)
    {
        $deleteForm = $this->createDeleteForm($type);

        return $this->render('AdminBundle:Type:show.html.twig', array(
            'type' => $type,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing type entity.
     *
     */
    public function editAction(Request $request, Type $type)
    {
        $deleteForm = $this->createDeleteForm($type);
        $editForm = $this->createForm('AdminBundle\Form\TypeType', $type);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A type have updated successfully.');

            return $this->redirectToRoute('type_index');
        }

        return $this->render('AdminBundle:Type:edit.html.twig', array(
            'type' => $type,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a type entity.
     *
     */
    public function deleteAction(Request $request, Type $type)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($type);
        $form->handleRequest($request);

        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($type);
                $em->flush();

                $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'A type have deleted successfully.');
            }
        } else {
            $em->remove($type);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A type have deleted successfully.');
        }

        

        return $this->redirectToRoute('type_index');
    }

    /**
     * Creates a form to delete a type entity.
     *
     * @param Type $type The type entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Type $type)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_delete', array('id' => $type->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
