<?php

namespace GuiasDocentes\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuiasDocentes\AppBundle\Entity\Consulta;
use GuiasDocentes\AppBundle\Form\ConsultanteType;
use GuiasDocentes\AppBundle\Entity\Consultante;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\Hilo;
use GuiasDocentes\AppBundle\Entity\Respuesta;
use GuiasDocentes\AppBundle\Entity\Asignatura;
use GuiasDocentes\AppBundle\Entity\PersonalRepository;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use GuiasDocentes\AppBundle\Form\HiloType;
use GuiasDocentes\AppBundle\Form\ConsultaType;
use GuiasDocentes\AppBundle\Form\RespuestaType;
use GuiasDocentes\AppBundle\Form\ConsultaHasAsignaturaType;





class FAQController extends Controller
{
  

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')
        ->getAllOrderProfiles();
        return $this->render('GuiasDocentesAppBundle:FAQ:index.html.twig', array('perfiles' => $perfiles));
    }
    
    public function gfaqAction(Request $request){
        $session = $request->getSession();
        $perfil = $session->get('perfil');
        if ((!isset($_POST['perfil'])) && (!isset($perfil))) {
            return $this->indexAction();
            
        }elseif(isset($_POST['perfil'])) {
            $perfil = $_POST['perfil'];
            /* Gestion de atributos de sesion */
            $session = $request->getSession();
            $session->set('perfil', $perfil);
        }
        
        /* Obtenemos las ids de los distintos grupos asociados a un perfil */
        $em = $this->getDoctrine()->getManager();
        $idgrupos = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
        ->getDistinctGroupsByPerfilOrdered($perfil);
        
        if (!$idgrupos) {
             throw $this->createNotFoundException(
                'No existen gurpos para el perfil seleccionado '.$perfil);
                
        }else{
            foreach ($idgrupos as $idgrupo){
                /* Dados los diferentes ids de grupos generamos un array de grupos */
                $grupos[]=$em->getRepository('GuiasDocentesAppBundle:Grupo')
                ->getGrupoById($idgrupo[1]);
                /* Dados los diferentes ids de grupos generamos un array indizado con las diferentes pf correspondientes al id grupal de indice*/
                $collectionPF[$idgrupo[1]] = $em->getRepository('GuiasDocentesAppBundle:Pf')
                ->getCollectionPFByGroupOrdered($idgrupo[1]);
            }
            
            /* Extraigamos el/los grupos de soporte para el perfil dado (Generalmente será uno) */
            /* Primeramente el id */
            $gs_ids = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
            ->findByPerfilnombre($perfil); /*Necesito comprobar si esta habilitado*/

            /* Una vez tenemos el/los ids extraigamos el/los objetos grupo soporte*/
            foreach ($gs_ids as $gs_id){
                $gs[] = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')
                ->findOneById($gs_id->getGruposoporteid());
            }

            return $this->render('GuiasDocentesAppBundle:FAQ:gfaq.html.twig', array('perfil' => $perfil, 'grupos'=> $grupos, 'PF' => $collectionPF, 'grupos_soporte' => $gs));
        }
    }

    public function contactoAction (Request $request){
        $session = $request->getSession();
        $perfil = $session->get('perfil');
        $role = 'consultante';
        $consultaHasAsignatura = new ConsultaHasAsignatura();
        $form = $this->createForm(new ConsultaHasAsignaturaType(), $consultaHasAsignatura);
        
        if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                try{
                    $form_request = $request->request->get('guiasdocentes_appbundle_consultahasasignatura');
                    $correoConsultante = $form_request["consulta"]["hiloid"]["consultanteemail"]["email"];
                    $consultante = $em->getRepository('GuiasDocentesAppBundle:Consultante')
                    ->findOneByEmail($correoConsultante);
                    $asignaturas = $this->subtr_asigna($form_request["asignaturaCodigo"]["codigo"]);
                    $num_asig= count($asignaturas);
                    $personal =  $em->getRepository('GuiasDocentesAppBundle:Personal')
                    ->findOneByEmail($form_request["consulta"]["hiloid"]["personalemail"]);
                    // Consulta sin asignaturas
                    if ($num_asig==0){
                        $consulta = new Consulta();
                        $hilo = new Hilo();
                        $hilo->setPersonalemail($personal);
                        $consulta->setTexto($form_request["consulta"]["texto"]);
                        $consulta->setHiloid($hilo);
                        // Nuevo consultante
                        if (is_null($consultante)){
                                $consultante = new Consultante();
                                $consultante->SetConsultante($correoConsultante, $form_request["consulta"]["hiloid"]["consultanteemail"]["nombre"], $form_request["consulta"]["hiloid"]["consultanteemail"]["apellidos"]);
                        }
                        $hilo->setConsultanteemail($consultante);
                        $em->persist($consulta);
                        $em->persist($hilo);
                        $em->flush();
                    // Consulta con una o mas asignaturas para un consultante nuevo o no
                    }else{
                        // Asignatura nueva y consultante nuevo
                        if (is_null($consultante) && ($num_asig==1)){
                            $asignatura =  $em->getRepository('GuiasDocentesAppBundle:Asignatura')
                            ->findOneByCodigo($form_request["asignaturaCodigo"]["codigo"]);
                            if (is_null($asignatura)){
                                $form->handleRequest($request);
                                if($form->isValid()){
                                    $em->persist($consultaHasAsignatura);
                                    $em->flush();
                                }
                            }else{
                                $hilo = $this->dbCustomPersist($form_request, $correoConsultante, $consultante, $asignaturas, $num_asig, $personal);
                            }
                        }else{
                            $hilo = $this->dbCustomPersist($form_request, $correoConsultante, $consultante, $asignaturas, $num_asig, $personal);
                        }
                    }
                    $email_values= array ('consulta' => $form_request["consulta"]["texto"], 'asignaturas' => $asignaturas, 'personal' => $personal, 'hilo' => $hilo);
                    try{
                        $this->sendMessageToSupport($email_values);
                        $em->getConnection()->commit();
                        return $this->resumeAction($email_values, $request, $role);
                    }catch(Exception $e){
                        $em->getConnection()->rollback();
                        throw $e;
                    }

                }catch (Exception $e){
                    $em->getConnection()->rollback();
                    throw $e;
                }
        }
        return $this->render('GuiasDocentesAppBundle:FAQ:contacto.html.twig', array('perfil'=>$perfil, 
            'form' => $form->createView()
        ));
    }
    
    public function historicoAction ($slug, $token, Request $request){
        $cod_hilo = base64_decode($slug);
        $email_cons = base64_decode($token);
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
        $is_personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($email_cons);
        $hilo = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findOneById($cod_hilo);
        if (isset($is_personal)){
            $role = 'soporte';
        }else{
            $role = 'consultante';
        }
        return $this->render('GuiasDocentesAppBundle:FAQ:historico.html.twig', array('hilo' => $hilo, "slug" => $slug, 'token' => $token, 'role' => $role));    
    }
    
    
    public function resumeAction ($email_values, Request $request, $role){
        $session = $request->getSession();
        $perfil = $session->get('perfil');
        if(is_null($email_values)){
            return $this->redirectToRoute('guias_docentes_app_homepage'); // Más bien deberia redireccionarse a una pagina de error
        }else{
            if ($role == 'consultante'){
                return $this->render('GuiasDocentesAppBundle:FAQ:resumeConsultante.html.twig', array('correoConsultante' => $email_values["hilo"]->getConsultanteEmail->getEmail(), 'perfil' => $perfil));
            }else{
                return $this->render('GuiasDocentesAppBundle:FAQ:resumeSoporte.html.twig', array('correoConsultante' => $email_values["hilo"]->getConsultanteEmail->getEmail(), 'perfil' => $perfil));
            }
        }
    }
    

    

    
    public function dbCustomPersist($form_request, $correoConsultante, $consultante, $asignaturas, $num_asig, $personal){
        $hilo = new Hilo();
        $em = $this->getDoctrine()->getManager();
        $hilo->setPersonalemail($personal);
        //Consultante no registrado
        if (is_null($consultante)){
            $consultante = new Consultante();
            $consultante->SetConsultante($correoConsultante, $form_request["consulta"]["hiloid"]["consultanteemail"]["nombre"], $form_request["consulta"]["hiloid"]["consultanteemail"]["apellidos"]);
        }
        $hilo->setConsultanteemail($consultante);
        $consulta = new Consulta();
        $consulta->setTexto($form_request["consulta"]["texto"]);
        $consulta->setHiloid($hilo);
        // Conjunto de asignaturas de nuevo registro o no
        for ($i=0; $i<$num_asig; ++$i){
            $consultaHasAsignatura = new ConsultaHasAsignatura();
            $asignatura = $em->getRepository('GuiasDocentesAppBundle:Asignatura')->findOneByCodigo($asignaturas[$i]);
            // Asignatura de nueva consulta
            if (is_null($asignatura)){
                $asignatura = new Asignatura();
                $asignatura->setCodigo($asignaturas[$i]);
            }
            $consultaHasAsignatura->setAsignaturaCodigo($asignatura);
            $consultaHasAsignatura->setConsulta($consulta);
            $em->persist($consultaHasAsignatura);
        }
        $em->persist($hilo);
        $em->flush();
        return $hilo;
    }
    
    
    public function sendMessageToSupport($info_message){
        $slug = $this->encodeCadena($info_message["hilo"]->getId());
        $token = $this->encodeCadena($info_message["personal"]->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject('Aplicación Guias Docentes Consulta')
            ->setFrom('soporteguiasdocentes@gmail.com')
            ->setTo($info_message["personal"]->getEmail())
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:FAQ:layoutEmailSoporte.html.twig',
                    array('email_values' => $info_message, 'slug' => $slug, 'token' => $token)
                ),
                'text/html'
            )
        ;
        return $this->get('mailer')->send($message);
    }
    
    public function sendReplyToConsultante($info_message){
        $slug = $this->encodeCadena($info_message["hilo"]->getId());
        $token = $this->encodeCadena($info_message["hilo"]->getConsultanteemail()->getEmail());
        $message = \Swift_Message::newInstance()
            ->setSubject('Aplicación Guias Docentes Consulta')
            ->setFrom('soporteguiasdocentes@gmail.com')
            ->setTo($info_message["hilo"]->getConsultanteemail()->getEmail())
            ->setBody(
                $this->renderView(
                    'GuiasDocentesAppBundle:FAQ:layoutEmailConsultante.html.twig',
                    array('email_values' => $info_message, 'slug' => $slug, 'token' => $token)
                ),
                'text/html'
            )
        ;
        return $this->get('mailer')->send($message);
    }
    

    public function subtr_asigna($asignaturas){
        if (is_null($asignaturas) || ($asignaturas =="")){
            return array();
        }else{
            //Eliminamos todos los caracteres de la cadena que no sean numericos salvo el separador ";"
            $asig_cotej = ereg_replace("[^0-9;]", "", $asignaturas);
            return explode(";", $asig_cotej);
        }
    }
    
    public function encodeCadena($cadena){
		return base64_encode($cadena);
		
    }
    public function setVistoAction($slug, $token, $consulta_id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $consulta = $em->getRepository('GuiasDocentesAppBundle:Consulta')->findOneById($consulta_id);
        $consulta->getVisto() == 1 ? $consulta->setVisto(0) : $consulta->setVisto(1);
        $em->persist($consulta);
        $em->flush();
        return $this->historicoAction($slug, $token, $request);
        
    }
    
    public function addRespuestaHiloAction($slug, $token, Request $request){
        $email_cons = base64_decode($token);
        $cod_hilo = base64_decode($slug);
        try{
            if ($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $hilo = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findOneById($cod_hilo);
                $params = $this->getRequest()->request->all();
                $role = $params["role"];
                $respuesta = new Respuesta();
                $consulta  = $em->getRepository('GuiasDocentesAppBundle:Consulta')->findOneById($params["id_consulta"]);
                $consulta->setVisto(1);
                $respuesta->setConsulta($consulta);
                $respuesta->setTexto($params["respuesta"]);
                $email_values= array ('consulta' => $consulta, 'consultante' => $hilo->getConsultanteemail(), 'hilo' => $hilo, 'respuesta' => $respuesta);
                if ($this->sendReplyToConsultante($email_values) == 1) {
                    $em->persist($respuesta);
                    $em->flush();
                    $em->getConnection()->commit();
                    // $session->getFlashBag()->add('notice', 'Profile updated');
                    return $this->resumeAction($email_values, $request, $role);
                }else{
                    return $this->indexAction($request);
                }
            }
        }catch(Exception $e){
                $em->getConnection()->rollback();
                throw $e;
        }
    }
    
    public function addConsultaHiloAction($slug, $token, Request $request){
        $email_cons = base64_decode($token);
        $cod_hilo = base64_decode($slug);
        try{ 
            if ($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $hilo = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findOneById($cod_hilo);
                $params = $this->getRequest()->request->all();
                $role = $params["role"];
                //Necesitamos las asignaturas de las anteriores consultas o meter un boton añadir
                $consultaHasAsignaturas_ant  = $em->getRepository('GuiasDocentesAppBundle:ConsultaHasAsignatura')->findByConsulta($params["id_consulta"]);
                foreach ($consultaHasAsignaturas_ant as $cha){
                    $asignaturas[] = $cha->getAsignaturaCodigo();
                }
                
                $consulta = new Consulta();
                $consulta->setTexto($params["respuesta"]);
                foreach ($asignatura as $asignaturas){
                    $consulta_has_asignatura= new ConsultaHasAsignatura();
                    $consulta_has_asignatura->setConsulta($consulta);
                    $consulta_has_asignatura->setConsulta($asignatura);
                    $em->persist($consulta_has_asignatura);
                }
                $email_values= array ('consulta' => $form_request["consulta"]["texto"], 'asignaturas' => $asignaturas, 'consultante' => $consultante, 'personal' => $personal, 'hilo' => $hilo);
                if ($this->sendReplyToConsultante($email_values) == 1) {
                    $em->flush();
                    $em->getConnection()->commit();
                    // $session->getFlashBag()->add('notice', 'Profile updated');
                    return $this->resumeAction($email_values, $request, $role);
                }else{
                    $this->indexAction($request);
                } 
            }
        }catch(Exception $e){
                $em->getConnection()->rollback();
                throw $e;
        }
    }
}
