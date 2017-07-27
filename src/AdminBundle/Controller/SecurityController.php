<?php

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class SecurityController extends BaseController
{
    /**
     * Overriding login to add custom logic.
     */
    public function loginAction(Request $request)
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') || $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                return new RedirectResponse($this->container->get('router')->generate('admin', array())); 
            } elseif ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                return new RedirectResponse($this->container->get('router')->generate('homepage', array())); 
            }
        }

        return parent::loginAction($request);
    }
}

