<?php

/**
 * @author David Rubio Jiménez en Universidad de Jaén
 * */

namespace GuiasDocentes\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use GuiasDocentes\AppBundle\Entity\Admin;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;




class SecurityController extends Controller
{
    
    public function loginAction(Request $request)
    {
        // $authenticationUtils = $this->get('security.authentication_utils');
        // // get the login error if there is one
        // $error = $authenticationUtils->getLastAuthenticationError();
    
        // // last username entered by the user
        // $lastUsername = $authenticationUtils->getLastUsername();
        
        $session = $request->getSession();
        // var_dump($session);
        // var_dump($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR));
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
    
        return $this->render(
            'GuiasDocentesAppBundle:AdminPanel:login.html.twig',
            array(
                // last username entered by the user
                // 'last_username' => $lastUsername,
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    public function createAction()
    {
    $user = new Admin();
          $user->setUsername('aa');
          $user->setEmail('admin@umahanov.com');

          $encoder = new MessageDigestPasswordEncoder('sha512',true,1);
          $password = $encoder->encodePassword('1234', $user->getSalt());
          $user->setPassword($password);
          $manager = $this->getDoctrine()->getManager();
          $manager->persist($user);

          $manager->flush();  

        return $this->render('GuiasDocentesAppBundle:AdminPanel:login.html.twig');
    }

}
