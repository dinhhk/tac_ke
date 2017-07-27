<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\TypeProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typeproduct controller.
 *
 */
class TypeProductController extends Controller
{
    /**
     * Lists all typeProduct entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeProducts = $em->getRepository('AdminBundle:TypeProduct')->findAll();
        
        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('type_product_delete', array('id' => ':USER_ID')))
            ->setMethod('DELETE')
            ->getForm();

        return $this->render('AdminBundle:TypeProduct:index.html.twig', array(
            'typeProducts' => $typeProducts,
            'delete_form' => $delete_form->createView()
        ));
    }

    /**
     * Creates a new typeProduct entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $typeProduct = new TypeProduct();
        $form = $this->createForm('AdminBundle\Form\TypeProductType', $typeProduct);
        $form->handleRequest($request);

        $sizes = $request->request->get('custom_size');
        $size_added = FALSE;
        if($sizes) {
            $sizes = explode(',', str_replace(array('[', ']'), '', $sizes));
            $unit = $typeProduct->getUnit();
            $type = $typeProduct->getType();
            foreach($sizes as $id) {
                $size = $em->getRepository('AdminBundle:Size')->find($id);
                if($size) {
                    $setTypeProduct = new TypeProduct();
                    $setTypeProduct->setType($type);
                    $setTypeProduct->setUnit($unit);
                    $setTypeProduct->setSize($size);
                    $em->persist($setTypeProduct);  
                    $size_added = TRUE;  
                }
            }
        }  

        $errors = '';
        if($size_added == FALSE) {
            $errors = 'This value should not be blank.';
        }

        if ($form->isSubmitted() && $form->isValid() && $size_added) {
            $em->flush();
            return $this->redirectToRoute('type_product_index');
        }

        return $this->render('AdminBundle:TypeProduct:new.html.twig', array(
            'typeProduct' => $typeProduct,
            'form' => $form->createView(),
            'errors' => $errors
        ));
    }

    /**
     * Finds and displays a typeProduct entity.
     *
     */
    public function showAction(TypeProduct $typeProduct)
    {
        $deleteForm = $this->createDeleteForm($typeProduct);

        return $this->render('AdminBundle:TypeProduct:show.html.twig', array(
            'typeProduct' => $typeProduct,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeProduct entity.
     *
     */
    public function editAction(Request $request, TypeProduct $typeProduct)
    {
        $deleteForm = $this->createDeleteForm($typeProduct);
        $editForm = $this->createForm('AdminBundle\Form\TypeProductType', $typeProduct);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_product_index');
        }

        return $this->render('AdminBundle:TypeProduct:edit.html.twig', array(
            'typeProduct' => $typeProduct,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeProduct entity.
     *
     */
    public function deleteAction(Request $request, TypeProduct $typeProduct)
    {
        $form = $this->createDeleteForm($typeProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeProduct);
            $em->flush();
        }

        return $this->redirectToRoute('type_product_index');
    }

    /**
     * Creates a form to delete a typeProduct entity.
     *
     * @param TypeProduct $typeProduct The typeProduct entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeProduct $typeProduct)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_product_delete', array('id' => $typeProduct->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
