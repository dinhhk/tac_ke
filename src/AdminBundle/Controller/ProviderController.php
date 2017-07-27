<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Provider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provider controller.
 *
 */
class ProviderController extends Controller
{
    /**
     * Lists all provider entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $providers = $em->getRepository('AdminBundle:Provider')->findAll();

        return $this->render('AdminBundle:Provider:index.html.twig', array(
            'providers' => $providers,
        ));
    }

    /**
     * Creates a new provider entity.
     *
     */
    public function newAction(Request $request)
    {
        $provider = new Provider();
        $form = $this->createForm('AdminBundle\Form\ProviderType', $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A provider have added successfully.');

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('AdminBundle:Provider:new.html.twig', array(
            'provider' => $provider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a provider entity.
     *
     */
    public function showAction(Provider $provider)
    {
        $deleteForm = $this->createDeleteForm($provider);

        return $this->render('AdminBundle:Provider:show.html.twig', array(
            'provider' => $provider,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing provider entity.
     *
     */
    public function editAction(Request $request, Provider $provider)
    {
        $deleteForm = $this->createDeleteForm($provider);
        $editForm = $this->createForm('AdminBundle\Form\ProviderType', $provider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A provider have updated successfully.');

            return $this->redirectToRoute('provider_index');
        }

        return $this->render('AdminBundle:Provider:edit.html.twig', array(
            'provider' => $provider,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a provider entity.
     *
     */
    public function deleteAction(Request $request, Provider $provider)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($provider);
        $form->handleRequest($request);

        if($request->getMethod() == 'DELETE') {
            if ($form->isSubmitted() && $form->isValid()) {
                $em->remove($provider);
                $em->flush();

                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'A provider have deleted successfully.');
            }
        } else {
            $em->remove($provider);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'A provider have deleted successfully.');
        }

        

        return $this->redirectToRoute('provider_index');
    }

    /**
     * Creates a form to delete a provider entity.
     *
     * @param Provider $provider The provider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Provider $provider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('provider_delete', array('id' => $provider->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
