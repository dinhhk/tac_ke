<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AdminBundle:Product')->findAll();

        return $this->render('AdminBundle:Product:index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $products_data = $form->getData();
            $product->upload();

            $em->persist($products_data);
            $em->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A product have added successfully.');

            return $this->redirectToRoute('product_index');
        }

        return $this->render('AdminBundle:Product:new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
            
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('AdminBundle:Product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AdminBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $product->upload();
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A product have updated successfully.');

            return $this->redirectToRoute('product_index');
        }

        $helper = $this->get('admin.service.algorithmic_helper');
        $token = $helper->encrypt_decrypt('encrypt', $product->getId());

        return $this->render('AdminBundle:Product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'token' => $token
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($product);
                $em->flush();

                $request->getSession()
                        ->getFlashBag()
                        ->add('success', 'A product have deleted successfully.');
            }
        } else {
            $em->remove($product);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A product have deleted successfully.');
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Remove Image and Set Image Value By Ajax
     *
     */
    public function removeImageAction(Request $request) {
        if($request->isXmlHttpRequest()) {
            $token = $request->request->get('token');
            $helper = $this->get('admin.service.algorithmic_helper');
            $id = $helper->encrypt_decrypt('decrypt', $token);
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('AdminBundle:Product');
            $product = $repository->find($id);
            $removed = FALSE;
            $message = 'Error in remove the file';
            if($product) {
               $product->removeFile($product->getImage());
               $product->setImage('');
               $em->flush();
               $removed = TRUE;
               $message = 'The file has removed successfully.'; 
            }

            return new Response(
                json_encode(['removed' => $removed, 'message' => $message]), 
                200, 
                array('Content-Type' => 'application/json')
            );
        }
    }

    /**
     * Get info of product
     */
    public function infoAction(Request $request) {
        if($request->isXmlHttpRequest()) {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                ->select('p')
                ->from('AdminBundle:Product', 'p')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();
            $results = $query->getArrayResult();
            $product = isset($results[0]) && !empty($results[0]) ? $results[0] : '';
            $status = FALSE;
            if($product) {
                $status = TRUE;
            }
            return new Response(json_encode(['status' => $status, 'product' => $product]), 200, array('Content-Type' => 'application/json'));
        }
    }
}
