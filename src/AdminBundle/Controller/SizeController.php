<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Size;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Size controller.
 *
 */
class SizeController extends Controller
{
    /**
     * Lists all size entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sizes = $em->getRepository('AdminBundle:Size')->findAll();
        if($request->isXmlHttpRequest()) {
            $data = array();
            foreach($sizes as $size) {
                $arr['id'] = $size->getId();
                $arr['name'] = $size->getName();
                array_push($data, $arr);
            }
            return new Response(
                json_encode(['data' => $data]), 
                200, 
                array('Content-Type' => 'application/json')
            );
        }

        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('size_delete', array('id' => ':USER_ID')))
            ->setMethod('DELETE')
            ->getForm();

        return $this->render('AdminBundle:Size:index.html.twig', array(
            'sizes' => $sizes,
            'delete_form' => $delete_form->createView()
        ));
    }

    /**
     * Creates a new size entity.
     *
     */
    public function newAction(Request $request)
    {
        $size = new Size();
        $form = $this->createForm('AdminBundle\Form\SizeType', $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($size);
            $em->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A size have added successfully.');

            return $this->redirectToRoute('size_index', array('id' => $size->getId()));
        }

        return $this->render('AdminBundle:Size:new.html.twig', array(
            'size' => $size,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a size entity.
     *
     */
    public function showAction(Size $size)
    {
        $deleteForm = $this->createDeleteForm($size);

        return $this->render('AdminBundle:Size:show.html.twig', array(
            'size' => $size,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing size entity.
     *
     */
    public function editAction(Request $request, Size $size)
    {
        $deleteForm = $this->createDeleteForm($size);
        $editForm = $this->createForm('AdminBundle\Form\SizeType', $size);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A size have updated successfully.');

            return $this->redirectToRoute('size_index', array('id' => $size->getId()));
        }

        return $this->render('AdminBundle:Size:edit.html.twig', array(
            'size' => $size,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a size entity.
     *
     */
    public function deleteAction(Request $request, Size $size)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($size);
        $form->handleRequest($request);

        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($size);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A size have deleted successfully.');
            } 
        } else {
            $em->remove($size);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A size have deleted successfully.');
        }
        

        return $this->redirectToRoute('size_index');
    }

    /**
     * Creates a form to delete a size entity.
     *
     * @param Size $size The size entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Size $size)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('size_delete', array('id' => $size->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
