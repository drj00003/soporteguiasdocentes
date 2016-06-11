<?php

/**
 * @author David Rubio Jiménez en Universidad de Jaén
 * */

namespace GuiasDocentes\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Container;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\Hilo;





class MailerManagementController extends Controller
{
    
    /**
     * Constructor por defecto de la clase
     * */
	 
    public function __construct(){
        $this->setContainer(new Container());
     }
     
    /**
	 * Función para el envio de mensajes customizados desde un servidor de correo desatendido al responsable de soporte asignado
	 * @param array $info_massage Conjunto de valores necesarios para el mensaje (destinatario, slug, token, layout mensaje)
	 * @return bool Todo correcto 1, algún error 0.
	 * */
  
    public function sendMessageToSupport($info_message){
        $slug = $this->encodeCadena($info_message["hilo"]->getId());
        $token = $this->encodeCadena($info_message["personal"]->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject('Aplicación Guias Docentes Consulta')
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($info_message["personal"]->getEmail())
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:FAQ:layoutEmailSoporte.html.twig',
                    array('email_values' => $info_message, 'slug' => $slug, 'token' => $token)
                ),
                'text/html'
            )
        ;
        // return 1;
        return $this->get('mailer')->send($message);
    }

    /**
	 * Función para el envio de mensajes customizados desde un servidor de correo desatendido al destinatario de la consulta del formulario
	 * @param array $info_massage Conjunto de valores necesarios para el mensaje (destinatario, slug, token, layout mensaje)
	 * @return bool Todo correcto 1, algún error 0.
	 * */
    
    public function sendReplyToConsultante($info_message){
        $slug = $this->encodeCadena($info_message["hilo"]->getId());
        $token = $this->encodeCadena($info_message["hilo"]->getConsultanteemail()->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject('Aplicación Guias Docentes Consulta')
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($info_message["hilo"]->getConsultanteemail()->getEmail())
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:FAQ:layoutEmailConsultante.html.twig',
                    array('email_values' => $info_message, 'slug' => $slug, 'token' => $token)
                ),
                'text/html'
            )
        ;
        // return 1;
        return $this->get('mailer')->send($message);
    }
    
    public function sendAdminMessage($email_values){
            $destinatarios = $this->mailerStringToArray($email_values["destinatarios"]);
            $message = \Swift_Message::newInstance()
            ->setSubject($email_values["subject"])
            ->setFrom($this->getParameter('mailer_user'))
            ->setcC($destinatarios)
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:MailerManagement:layoutAdminEmail.html.twig',
                    array('email_values' => $email_values)
                ),
                'text/html'
            )
        ;
        return $this->get('mailer')->send($message);
    }
   
   
    public function sendRecoverMessage($email_values){
            $message = \Swift_Message::newInstance()
            ->setSubject('Recuperación de contraseña')
            ->setFrom($this->getParameter('mailer_user'))
            ->setTo($email_values["recover-email"])
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:MailerManagement:layoutRecoverUser.html.twig',
                    array('email_values' => $email_values)
                ),
                'text/html'
            )
        ;
        return $this->get('mailer')->send($message);
    }    

    /**
	 * Función para la codificación de una cadena con el algoritmo Base 64
	 * @param string $cadena Cadena a codificar
	 * @return string La cadena codificada
	 * */
	 
    public function encodeCadena($cadena){
		return base64_encode($cadena);
    }
    
    private function mailerStringToArray($cadena){
        return explode (',', $cadena);
    }
}
