<?php

/**
 * @author David Rubio Jiménez en Universidad de Jaén
 * */

namespace GuiasDocentes\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\Container;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use GuiasDocentes\AppBundle\Entity\Administrador;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;




class SecurityController extends Controller
{
    
    /**
     * Constructor por defecto de la clase
     * */
	 
    public function __construct(){
        $this->setContainer(new Container());
     }
    
    /**
	 * Función de login para el acceso a la sección de administración
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de lógin
	 * */
    
    public function loginAction(Request $request)
    {

        $session = $request->getSession();
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
    
    /**
     * @Route("/logout", name="logout")
	 * Función de deslogueo en el panel de administración
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * */
    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
    }
    
    /**
	 * Función para generar un nuevo pass para la funcion de recuperacion de usuario
	 * @return strin Nuevo pass
	 * */    
    
    public function generaPass(){
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);
         
        $pass = "";
        $longitudPass=5;
         
        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
         
            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

}
