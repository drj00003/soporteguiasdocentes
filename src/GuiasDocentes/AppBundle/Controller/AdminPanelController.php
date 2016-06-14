<?php
/**
 * @author David Rubio Jiménez en Universidad de Jaén
 * */

namespace GuiasDocentes\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuiasDocentes\AppBundle\Entity\Consulta;
use GuiasDocentes\AppBundle\Form\ConsultanteType;
use GuiasDocentes\AppBundle\Entity\Consultante;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\Perfil;
use GuiasDocentes\AppBundle\Entity\Hilo;
use GuiasDocentes\AppBundle\Entity\Pf;
use GuiasDocentes\AppBundle\Entity\Respuesta;
use GuiasDocentes\AppBundle\Entity\Grupo;
use GuiasDocentes\AppBundle\Entity\Asignatura;
use GuiasDocentes\AppBundle\Entity\PersonalRepository;
use GuiasDocentes\AppBundle\Entity\GrupoRepository;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use GuiasDocentes\AppBundle\Entity\GrupoSoporteHasPerfil;
use GuiasDocentes\AppBundle\Entity\PerfilGrupoOrder;
use GuiasDocentes\AppBundle\Entity\TematicaSoporte;
use GuiasDocentes\AppBundle\Entity\GrupoSoporte;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuiasDocentes\AppBundle\Entity\Administrador;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\HttpFoundation\Session\Session;
use GuiasDocentes\AppBundle\Controller\MailerManagementController;
use GuiasDocentes\AppBundle\Controller\SecurityController;
use Symfony\Component\Validator\Constraints\DateTime;





class AdminPanelController extends Controller
{
    
    /******************** INICIO REGEX ADMIN ************************/
    
    /**
	 * Función de carga de la página tablón
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de index
	 * */
  
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $usr= $this->get('security.context')->getToken()->getUser();
        $num_consultantes = $em->getRepository('GuiasDocentesAppBundle:Consultante')->countDistinctConsultantes();
        $num_consultas = $em->getRepository('GuiasDocentesAppBundle:Consulta')->countDistinctConsultas();
        $num_faqs = count($em->getRepository('GuiasDocentesAppBundle:PF')->findByModificadorid($usr->getId()));
        $session->set('num_consultantes', $num_consultantes);
        $session->set('num_consultas', $num_consultas);
        $session->set('num_faqs', $num_faqs);
        $session->set('usr', $usr->getUsername());
        $personales = $em->getRepository('GuiasDocentesAppBundle:Personal')->findAll();
        $personalesToString = $this->consultantesToString($personales);

        return $this->render('GuiasDocentesAppBundle:AdminPanel:index.html.twig', array('num_consultantes' => $num_consultantes, 'num_consultas' => $num_consultas, 'personal' => $personalesToString));
    }
    
    /**
	 * Función de carga de la página de perfil de administrador
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de perfil
	 * */
    
    public function perfilAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:perfil.html.twig', array('user'=>$usr));        
    }
    
    /**
	 * Función de carga de la página de grupos de preguntas frecuentes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de grupo de preguntas frecuentes
	 * */
    
    public function groupAction (Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $groupForProfile = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
        ->getAllGroupOrderedByOrden();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:group.html.twig', array('gfps' => $groupForProfile, 'ok' => $ok));
    }
    
    /**
	 * Función de carga de la página de estadisticas
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de estadisticas
	 * */

    public function StaticsAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:statics.html.twig');
        
    }
    
    /**
	 * Función de carga de la página de preguntas frecuentes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de preguntas frecuentes
	 * */
    
    public function pfAction(Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $pfs = $em->getRepository('GuiasDocentesAppBundle:Pf')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:pf.html.twig', array('pfs' => $pfs, 'ok' => $ok));    
    }
    
    /**
	 * Función de carga de la página de perfiles de acceso a la faq
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de perfiles de acceso a la faq
	 * */
    
    public function profilesAction(Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:profiles.html.twig', array('perfiles' => $profiles, 'ok'=>$ok));    
    }
    
    /**
	 * Función de carga de la página de grupos de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de grupos de soporte
	 * */
    
    public function SupportGroupAction(Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:grupos_soporte.html.twig', array('grupos_soporte' => $grupos_soporte, 'ok' => $ok));    
    }
    
    /**
	 * Función de carga de la página de tematicas de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de temáticas de soporte
	 * */
    
    public function TematicaSoporteAction(Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $tematicas_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:tematica_soporte.html.twig', array('tematicas_soporte' => $tematicas_soporte, 'ok' => $ok));    
    }
    
    /**
	 * Función de carga de la página miembros de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página del personal de soporte
	 * */
    
    public function miembroSoporteAction(Request $request){
        $session = $request->getSession();
        $ok = $session->get('result');
        $session->remove('result');
        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:miembro_soporte.html.twig', array('personales' => $miembros_soporte, 'ok' => $ok));    
    }
    
    /**
	 * Función de carga de la página de gestión de informes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página de gestión de informes
	 * */
    
    public function informeAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:informe.html.twig', array('personales' => $miembros_soporte));      
    }

/***** FIN de REGEX ****/

    /**
	 * Función encargada de realizar la limpieza de los registros consultas/respuestas asociados a determinado miembro de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Página limpieza de registros por personal
	 * */
    
    public function cleanAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $hilos = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findByPersonalemail($params["personal"]);
                $em->getConnection()->beginTransaction();
                foreach ($hilos as $hilo){
                    $em->remove($hilo);
                }
                $em->flush();
                $em->getConnection()->commit();
                $ok = true;
            }else{
                $ok = false;
                return $this->render('GuiasDocentesAppBundle:AdminPanel:clean.html.twig', array('personales' => $miembros_soporte, 'ok' => $ok));
            }
             return $this->render('GuiasDocentesAppBundle:AdminPanel:clean.html.twig', array('personales' => $miembros_soporte, 'ok' => $ok));
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
        return $this->render('GuiasDocentesAppBundle:AdminPanel:clean.html.twig', array('personales' => $miembros_soporte));  
    }
    
    /**
	 * Función de control para el envío de email desde la pantalla de administración
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * */
	 
    public function mailerAdminAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                // Cargamos el servicio MailerManagement
                $mailerService = $this->get('mailer_management');
                if ($mailerService->sendAdminMessage($params)){
                    $this->indexAction($request);
                }else{
                    $this->indexAction($request);
                }
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }    
    }
    /**
	 * Función de control para la recuperación de las credenciales de acceso para el perfil administrador
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * */ 
	 
    public function recoverAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $administrador = $em->getRepository('GuiasDocentesAppBundle:Administrador')->findOneByEmail($params["recover-email"]);
                // var_dump($administrador);
                if (isset($administrador)){
                    $params["username"] = $administrador->getUsername();
                    $securityService = $this->get('security');
                    $new_pass = $securityService->generaPass();
                    $params["password"] = $new_pass;
                    $encoder = new MessageDigestPasswordEncoder('sha512',true,1);
                    $encrypt_pass = $encoder->encodePassword($new_pass, $administrador->getSalt());
                    $administrador->setPassword($encrypt_pass);
                    $em->getConnection()->beginTransaction();
                    $em->persist($administrador);
                    $em->flush();
                    $em->getConnection()->commit();
                // Cargamos el servicio MailerManagement
                    $mailerService = $this->get('mailer_management');
                    if ($mailerService->sendRecoverMessage($params)){
                        return $this->redirect($this->getRequest()->getBasePath().'/admin', 301);
                    }
                }else{
                    return $this->redirect($this->getRequest()->getBasePath().'/admin', 301);
                }
            }else{
                return $this->redirect($this->getRequest()->getBasePath().'/admin', 301);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            
        }     
    }
    
    /**
	 * Función de control para la generación de informes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Contenido HTML del informe
	 * */
	 
    public function layoutPDFAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        // $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($email_soporte);
        $hilos = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findByPersonalemail("drj00003@gmail.com");
        return $this->render('GuiasDocentesAppBundle:AdminPanel:layoutPDF.html.twig', array('hilos' => $hilos));         
    }

    /******************** SETER, DELETES AND CREATES ACTIONS *************************************/
    
    /**                     *
    *       Grupos PF       *
    *                       *
    */
    
    /**
	 * Función para la creación de grupos de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html HTML con el formulario de creación
	 * */
    
    public function createGroupAction(Request $request){
        $result = 0;
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')
        ->findAll();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $pgo = new PerfilGrupoOrder();
                $grupo = new Grupo();
                $grupo->setNombre($params["nombre"]);
                $pgo->setGrupoid($grupo);
                $pgo->setOrden($params["orden"]);
                $perfil = $em->getRepository('GuiasDocentesAppBundle:Perfil')
                ->findOneByNombre($params["perfil"]);
                $pgo->setPerfilnombre($perfil);
                $em->getConnection()->beginTransaction();
                $em->persist($pgo);
                $em->flush();
                $em->getConnection()->commit();
                $result=1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-group.html.twig', array('perfiles' => $perfiles, 'ok' => $result));
    }
    
    /**
	 * Función para la actualización de valores de grupos de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección hacia la función de gestion de grupos.
	 * */
	 
    public function GroupSetAction(Request $request){
        $result =0;
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pgo = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findOneById($params["id_grupo_perfil"]);
                $pgo->setOrden($params["orden"]);
                $grupo = $pgo->getGrupoid();
                $grupo->setNombre($params["nombre"]);
                $perfil = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["perfil"]);
                $pgo->setPerfilnombre($perfil);
                $em->persist($pgo);
                $em->flush();
                $em->getConnection()->commit();
                $result =1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result= -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_group_manag'));
    }
    
    /**
	 * Función de borrado de grupos de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección hacia la función de gestion de grupos.
	 * */
    
    public function GroupDeleteAction(Request $request){
       $result =0;
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pgo = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findOneById($params["id_grupo_perfil"]);
                $em->remove($pgo);
                $em->flush();
                $em->getConnection()->commit();
                $result =1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_group_manag'));    
    }
    
    /**                         *
    *       Administrador       *
    *                           *
    */
    
    /**
	 * Función para la creación de miembros de administración
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html HTML con el formulario para la creación de usuarios de administración.
	 * */
    
    public function createAction(Request $request){
        $result = 0;
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $user = new Administrador();
                $user->setUsername($params["username"]);
                $user->setEmail($params["email"]);
                $encoder = new MessageDigestPasswordEncoder('sha512',true,1);
                $password = $encoder->encodePassword($params["password"], $user->getSalt());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $em->persist($user);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-admin.html.twig', array('ok' => $result));
    }
    
    /**                     *
    *       Perfiles        *
    *                       *
    */
    
    /**
	 * Función para la creación de perfiles de acceso a la FAQ
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return HTML HMTL con el formulario de creación de perfiles
	 * */
    
    
    public function createProfileAction(Request $request){
            $result =0;
        try{
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findAll();
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $perfil = new Perfil();
                $perfil->setNombre($params["nombre"]);
                $perfil->setOrden($params["orden"]);
                if (isset($params["grupo_soporte"])){
                    $grupo_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
                    $gshp= new GrupoSoporteHasPerfil();
                    $gshp->setGruposoporteid($grupo_soporte);
                    $gshp->setPerfilnombre($perfil);
                    $gshp->setHabilitada(1);
                    $em->persist($gshp);
                }else{
                    $em->persist($perfil);  
                }
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result=-1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-profile.html.twig', array('ok' => $result, 'grupos_soporte' => $grupos_soporte));
    }
    
    
    /**
	 * Función para la actualización de perfiles de acceso a la FAQ
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirecciona a la routa de gestión de perfiles.
	 * */
    
    public function ProfileSetAction(Request $request){
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                // var_dump($params);
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $perfil =  $gshp->getPerfilnombre();
                $perfil->setNombre($params["nombre"]);
                $perfil->setOrden($params["orden"]);
                $gshp->setPerfilnombre($perfil);
                $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
                $gshp->setGruposoporteid($grupo_soporte);
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_profiles_manage'));
    }
    
    /**
	 * Función para el borrado de perfiles de acceso a la FAQ
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirecciona a la routa de gestión de perfiles.
	 * */
    
    public function ProfileDeleteAction(Request $request){
       $result = 0;
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $em->remove($gshp);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_profiles_manage'));
    }
    
    
    /**                                 *
    *       Preguntas Frecuentes        *
    *                                   *
    */
    
    
    /**
	 * Función para la creación de preguntas frecuentes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html HTML con el formulario de creación de preguntas frecuentes
	 * */
    
    public function createPFAction(Request $request){
        $result = 0;
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findAll();
        $usr= $this->get('security.context')->getToken()->getUser();
        foreach ($perfiles as $perfil){
            $grupos = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findByPerfilnombre($perfil->getNombre());
            foreach ($grupos as $grupo){
                $p[$perfil->getNombre()][$grupo->getGrupoid()->getId()]=$grupo->getGrupoid()->getNombre();
            }
        }
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $pf = new Pf();
                $pf->setRespuesta($params["respuesta"]);
                $pf->setPregunta($params["pregunta"]);
                $pf->setOrden($params["orden"]);
                $pf->setHabilitada($params["habilitada"]);
                $pf->setCreador($usr->getUsername());
                $grupo = $em->getRepository('GuiasDocentesAppBundle:Grupo')->findOneById($params["grupo"]);
                $pf->setGrupoid($grupo);
                $em->getConnection()->beginTransaction();
                $em->persist($pf);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-pf.html.twig', array('perfiles_grupos' => $p, 'ok' => $result));
    }
    
    /**
	 * Función para la actualización de preguntas frecuentes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la routa que sirve la web para la gestión de preguntas frecuentes
	 * */
    
    public function PFSetAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $result = 0;
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pf = $em->getRepository('GuiasDocentesAppBundle:Pf')->findOneById($params["id_pf"]);
                $pf->setPregunta($params["pregunta"]);
                $pf->setRespuesta($params["respuesta"]);
                $pf->setHabilitada($params["habilitada"]);
                $pf->setOrden($params["orden"]);
                $pf->setModificadorid($usr);
                $grupo = $em->getRepository('GuiasDocentesAppBundle:Grupo')->findOneById($params["grupo"]);
                $pf->setGrupoid($grupo);
                $pf->setFecham(new \Datetime());
                $em->persist($pf);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_pf_manage'));
    }
    
    
    /**
	 * Función para el borrado de preguntas frecuentes
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la routa que sirve la web para la gestión de preguntas frecuentes
	 * */
    
    public function PFDeleteAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pf = $em->getRepository('GuiasDocentesAppBundle:Pf')->findOneById($params["id_pf"]);
                $em->remove($pf);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_pf_manage'));
    }
    
    
    /**                             *
    *       Grupos Soporte          *
    *                               *
    */
    
    /**
	 * Función para la de los grupos especiales denominados de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html HTML con el formulario de creación de grupos de soporte
	 * */
    
    public function createSupportGroupAction(Request $request){
        $result = 0;
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findAll();
        try{
            if ($request->isMethod('POST')){
                $usr= $this->get('security.context')->getToken()->getUser();
                $params = $this->getRequest()->request->all();
                $gshp = new GrupoSoporteHasPerfil();
                $gs = new GrupoSoporte();
                $gs->setNombre($params["nombre"]);
                $gs->setPregunta($params["pregunta"]);
                $gs->setRespuesta($params["respuesta"]);
                $gs->setAdministradorid($usr);
                $gshp->setGruposoporteid($gs);
                $perfil = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["perfil"]);
                $gshp->setPerfilnombre($perfil);
                $gshp->setHabilitada($params["habilitada"]);
                $em->getConnection()->beginTransaction();
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result -1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-support_group.html.twig', array('perfiles' => $perfiles, 'ok' => $result));
    }
    
    
    /**
	 * Función para la actualización de los grupos especiales denominados de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la gestión de preguntas frecuentes
	 * */
    
    public function SupportGroupSetAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $result = 0;
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["perfil"]);
                $gshp->setPerfilnombre($perfil);
                $grupo_soporte =  $gshp->getGruposoporteid();
                $grupo_soporte->setPregunta($params["nombre"]);
                $grupo_soporte->setPregunta($params["pregunta"]);
                $grupo_soporte->setRespuesta($params["respuesta"]);
                $grupo_soporte->setAdministradorid($usr);
                $gshp->setGruposoporteid($grupo_soporte);
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            throw $e;
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_group_support_manag'));
    }

    /**
	 * Función para el borrado de los grupos especiales denominados de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la gestión de preguntas frecuentes
	 * */

    
    public function SupportGroupDeleteAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $em->remove($gshp);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_group_support_manag'));
    }    
 
    /**                                 *
    *       Temática Soporte            *
    *                                   *
    */

    /**
	 * Función para la creación de una temática de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return html Formulario para la creación de temáticas de soporte
	 * */
    
    public function createTematicaSoporteAction(Request $request){
        $result = 0;
        $em = $this->getDoctrine()->getManager();
        $personales = $em->getRepository('GuiasDocentesAppBundle:Personal')->findAll();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $ts = new TematicaSoporte();
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($params["personal"]);
                $ts->setPersonalEmail($personal);
                $ts->setEnunciado($params["enunciado"]);
                $ts->setOrden($params["orden"]);
                $em->getConnection()->beginTransaction();
                $em->persist($ts);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-tematica_soporte.html.twig', array('personales' => $personales, 'ok' => $result));
    }
    
    /**
	 * Función para la actualización de una temática de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la gestión de temáticas de soporte
	 * */   
	 
    public function TematicaSoporteSetAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $tematica_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')->findOneById($params["id_tematica_soporte"]);
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($params["personal"]);
                $tematica_soporte->setEnunciado($params["enunciado"]);
                $tematica_soporte->setOrden($params["orden"]);
                $tematica_soporte->setPersonalEmail($personal);
                $em->persist($tematica_soporte);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_tematica_soporte_manage'));
    }

    /**
	 * Función para el borrado de una temática de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la gestión de temáticas de soporte
	 * */   
    
    public function TematicaSoporteDeleteAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $tematica_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')->findOneById($params["id_tematica_soporte"]);
                $em->remove($tematica_soporte);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
            throw $e;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_tematica_soporte_manage'));
    }

    /**                                 *
    *       Personal de Soporte         *
    *                                   *
    */
    
    /**
	 * Función de alta de un personal soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return HTML Formulario para la creación de un personal de soporte
	 * */ 
	 
    public function createMiembroSoporteAction(Request $request){
        $result = 0;
        try{
            if ($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $params = $this->getRequest()->request->all();
                $personal = new Personal();
                $personal->setEmail($params["email"]);
                $personal->setNombre($params["nombre"]);
                $personal->setApellidos($params["apellidos"]);
                $personal->setDepartamento($params["departamento"]);
                $em->getConnection()->beginTransaction();
                $em->persist($personal);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-miembro_soporte.html.twig', array('ok' => $result));
    }

    /**
	 * Función para la actualización de un miembro de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la visualización de los diferentes miembros de soporte
	 * */ 

    
    public function MiembroSoporteSetAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneById($params["email"]);
                $personal->setNombre($params["nombre"]);
                $personal->setApellidos($params["apellidos"]);
                $personal->setDepartamento($params["departamento"]);
                $em->persist($personal);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_miembro_soporte_manage'));
    }

    /**
	 * Función para el borrado de un miembro de soporte
	 * @param request $request Objeto de la clase request que entre otros funcionalidades de validación y seguridad nos sirver para recuperar informac
	 * de contexto y sesión
	 * @return Route Redirección a la función para la visualización de los diferentes miembros de soporte
	 * */ 
    
    public function MiembroSoporteDeleteAction(Request $request){
      $result = 0;
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($params["email"]);
                $em->remove($personal);
                $em->flush();
                $em->getConnection()->commit();
                $result = 1;
            }else{
                $this->indexAction($request);
            }
        }catch(\Exception $e){
            $em->getConnection()->rollback();
            $result = -1;
        }
        $session = $request->getSession();
        $session->set('result', $result);
        return $this->redirect($this->generateUrl('guias_docentes_app_admin_panel_miembro_soporte_manage'));
    } 

    
    /******************** FIN SET Y DELETE ACTIONS *********************************/


   
/************************** FUNCIONES JSON **************************************/

    /**
	 * Función para obtener los diferentes perfiles de acceso a la FAQ dados de alta en el sistema
	 * @return Json  Json array con el conjunto de nombres de perfiles dados de alta en la FAQ
	 * */ 

    public function getProfilesAction(){
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')
        ->findAll();
        $response = new JsonResponse();
        foreach ($perfiles as $perfil){
            $perfil_nombre[]=$perfil->getNombre();
        }
        $response->setData(array(
            'success' => true, 'data'=>$perfil_nombre
        ));
        return $response;
    }

    /**
	 * Función para obtener los diferentes grupos de soporte dados de alta en el sistema
	 * @return JSON Json array de grupos de soporte, con clave id grupo y valor el nombre del mismo
	 * */ 

    
    public function GetSupportGroupAction(){
        $em = $this->getDoctrine()->getManager();
        $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')
        ->findAll();
        $response = new JsonResponse();
        foreach ($grupos_soporte as $grupo_soporte){
            $grupo_soporte_nombre[$grupo_soporte->getId()]=$grupo_soporte->getNombre();
        }
        $response->setData(array(
            'success' => true, 'data'=>$grupo_soporte_nombre
        ));
        return $response;
    }
    
    /**
	 * Función para obtener los diferentes grupos  dados de alta en el sistema
	 * @return JSON Json array multidimensional de grupos, clave de primer nivel perfil nombre, clave de segundo nivel id del grupo y valor el nombre
	 * de grupo correspondiente
	 * */     
    public function GetGroupAction(){
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findAll();
        foreach ($perfiles as $perfil){
            $grupos = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findByPerfilnombre($perfil->getNombre());
            foreach ($grupos as $grupo){
                $p[$perfil->getNombre()][$grupo->getGrupoid()->getId()]=$grupo->getGrupoid()->getNombre();
            }
        }
        $response->setData(array(
            'success' => true, 'data'=>$p
        ));
        return $response;
    }


    /**
	 * Función para obtener los diferentes miembros de soporte dados de alta en el sistema
	 * @return JSON Json array de personal, clave email del personal, valor el email del mismo
	 * de grupo correspondiente
	 * */   
    public function getPersonalesAction(){
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $personales = $em->getRepository('GuiasDocentesAppBundle:Personal')->findAll();
        foreach ($personales as $personal){
            $personal_nombre[$personal->getEmail()]=$personal->getEmail();
        }
        $response->setData(array(
            'success' => true, 'data'=>$personal_nombre
        ));
        return $response;
    }
    
    /**
	 * Función para obtener el número de consultas generadas en un año natural clasificadas por meses
	 * @return JSON Json array con el número de consultas, clave concatenación del año y el mes en numerico (2016-1), 
	 * número de consultas para dicho mes y año.
	 * */   
    public function getNumConsultasByMonthAction(){
        $em = $this->getDoctrine()->getManager();
        $num_consultasByMoth = $em->getRepository('GuiasDocentesAppBundle:Consulta')
        ->getNumConsultasByMonth('2016');
        foreach ($num_consultasByMoth as $key => $value) {
            $cad = '2016-'.$key;
            $cbm[$cad]=$value;
        }
        $response = new JsonResponse();
        $response->setData(array(
            'success' => true, 'data'=>$cbm
        ));
        return $response;
    }
    
    public function getProfilesSoporteAction(){
        return $this->getProfilesAction();
    }
    
    

/************ Fin Funciones JSON ***********************/

/**************** Funciones Auxiliares **********************/

    /**
	 * Función para la conversión de correos a una cadena entendible para el servicio de correo de administración
	 * @params Array $consultantes Array de destinatarios de la consulta
	 * @return String $cadena Cadena compuesta por la concatenación de los destinatios del correo
	 * */  
  
    private function consultantesToString($consultantes){
        $cadena ="";
        foreach ($consultantes as $consultante) {
            $cadena = $cadena.$consultante->getEmail().',';
        }
        return $cadena;
    }
    
}

/**************** Fin de funciones Auxiliares **********************/