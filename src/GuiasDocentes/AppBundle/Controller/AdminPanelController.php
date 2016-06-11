<?php

namespace GuiasDocentes\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GuiasDocentes\AppBundle\Entity\Consulta;
use GuiasDocentes\AppBundle\Form\ConsultanteType;
use GuiasDocentes\AppBundle\Entity\Consultante;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\Hilo;
use GuiasDocentes\AppBundle\Entity\Pf;
use GuiasDocentes\AppBundle\Entity\Respuesta;
use GuiasDocentes\AppBundle\Entity\Asignatura;
use GuiasDocentes\AppBundle\Entity\PersonalRepository;
use GuiasDocentes\AppBundle\Entity\GrupoRepository;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use GuiasDocentes\AppBundle\Form\HiloType;
use GuiasDocentes\AppBundle\Form\ConsultaType;
use GuiasDocentes\AppBundle\Form\RespuestaType;
use GuiasDocentes\AppBundle\Form\ConsultaHasAsignaturaType;
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
    
    
    public function perfilAction(){
        $usr= $this->get('security.context')->getToken()->getUser();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:perfil.html.twig', array('user'=>$usr));        
    }
    
    public function groupAction (){

        $em = $this->getDoctrine()->getManager();
        $groupForProfile = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
        ->getAllGroupOrderedByOrden();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:group.html.twig', array('gfps' => $groupForProfile));
    }
    


    public function StaticsAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:statics.html.twig');
        
    }
    
    
    public function pfAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $pfs = $em->getRepository('GuiasDocentesAppBundle:Pf')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:pf.html.twig', array('pfs' => $pfs));    
    }
    
    public function profilesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:profiles.html.twig', array('perfiles' => $profiles));    
    }
    
    public function SupportGroupAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:grupos_soporte.html.twig', array('grupos_soporte' => $grupos_soporte));    
    }
    
    public function TematicaSoporteAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $tematicas_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:tematica_soporte.html.twig', array('tematicas_soporte' => $tematicas_soporte));    
    }
    
    public function miembroSoporteAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:miembro_soporte.html.twig', array('personales' => $miembros_soporte));    
    }

/***** FIN de REGEX ****/
    
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
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }    
    }
    
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
                        return $this->redirect($this->getRequest()->getBasePath().'/app_dev.php/admin', 301);
                    }
                }else{
                    return $this->redirect($this->getRequest()->getBasePath().'/app_dev.php/admin', 301);
                }
            }else{
                return $this->redirect($this->getRequest()->getBasePath().'/app_dev.php/admin', 301);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }     
    }

    /******************** SETER, DELETES AND CREATES ACTIONS *************************************/
    
    /**                     *
    *       Grupos PF       *
    *                       *
    */
    
    public function createGroupAction(Request $request){

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
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-group.html.twig', array('perfiles' => $perfiles));
    }
    
    public function GroupSetAction(Request $request){
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                var_dump($params);die;
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pgo = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findOneById($params["id_grupo_perfil"]);
                $pgo->setOrden($params["orden"]);
                $grupo = $pgo->getGrupoid();
                $grupo->setNombre($params["nombre"]);
                $perfil = $pgo->getPerfilnombre();
                
                $em->persist($pgo);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function GroupDeleteAction(Request $request){
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                var_dump($params);die;
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pgo = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')->findOneById($params["id_grupo_perfil"]);
                $em->remove($pgo);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    /**                         *
    *       Administrador       *
    *                           *
    */
    
    public function createAction(Request $request){

        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $user = new Admin();
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
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-admin.html.twig');
    }
    
    /**                     *
    *       Perfiles        *
    *                       *
    */
    
    public function createProfileAction(Request $request){

        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $perfil = new Perfil();
                $perfil->setNombre($params["nombre"]);
                $perfil->setOrden($params["orden"]);
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $em->persist($perfil);
                $em->flush();
                $em->getConnection()->commit();
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-profile.html.twig');
    }
    
    public function ProfileSetAction(Request $request){
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                var_dump($params);die;
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["nombre"]);
                $gshp->setPerfilnombre($perfil);
                $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
                $gshp->setGruposoporteid($grupo_soporte);
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function ProfileDeleteAction(Request $request){
       try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                var_dump($params);die;
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $em->remove($gshp);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    
    /**                                 *
    *       Preguntas Frecuentes        *
    *                                   *
    */
    
    
    public function createPFAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findAll();
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
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-pf.html.twig', array('perfiles_grupos' => $p));
    }
    
    public function PFSetAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function PFDeleteAction(Request $request){
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $pf = $em->getRepository('GuiasDocentesAppBundle:Pf')->findOneById($params["id_pf"]);
                $em->remove($pf);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    
    /**                             *
    *       Grupos Soporte          *
    *                               *
    */
    
    public function createSupportGroupAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findAll();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $gshp = new GrupoSoporteHasPerfil();
                $gs = new GrupoSoporte();
                $gs->setNombre($params["nombre"]);
                $gs->setPregunta($params["pregunta"]);
                $gs->setRespuesta($params["respuesta"]);
                $gshp->setGruposoporteid($gs);
                $perfil = $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["perfil"]);
                $gshp->setPerfilnombre($perfil);
                $ghsp->setHabilitada($params["habilitada"]);
                $em->getConnection()->beginTransaction();
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-support_group.html.twig', array('perfiles' => $perfiles));
    }
    
    public function SupportGroupSetAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["perfil"]);
                $gshp->setPerfilnombre($perfil);
                $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
                $grupo_soporte->setPregunta($params["nombre"]);
                $grupo_soporte->setPregunta($params["pregunta"]);
                $grupo_soporte->setRespuesta($params["respuesta"]);
                $grupo_soporte->setAdministradorid($usr);
                $gshp->setGruposoporteid($grupo_soporte);
                $em->persist($gshp);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function SupportGroupDeleteAction(Request $request){
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
                $em->remove($gshp);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }    
 
    /**                                 *
    *       Temática Soporte            *
    *                                   *
    */
    
    public function createTematicaSoporteAction(Request $request){

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
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-tematica_soporte.html.twig', array('personales' => $personales));
    }
    
    public function TematicaSoporteSetAction(Request $request){
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $tematica_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')->findOneById($params["id_tematica_soporte"]);
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($params["email"]);
                $tematica_soporte->setEnunciado($params["enunciado"]);
                $tematica_soporte->setOrden($params["orden"]);
                $tematica_soporte->setPersonalEmail($personal);
                $em->persist($tematica_soporte);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function TematicaSoporteDeleteAction(Request $request){
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $tematica_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')->findOneById($params["id_tematica_soporte"]);
                $em->remove($tematica_soporte);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }

    /**                                 *
    *       Personal de Soporte         *
    *                                   *
    */
    
    public function createMiembroSoporteAction(Request $request){

        try{
            if ($request->isMethod('POST')){
                $em = $this->getDoctrine()->getManager();
                $params = $this->getRequest()->request->all();
                $personal = new Personal();
                $personal->setEmail($params["email"]);
                $personal->setNombre($params["nombre"]);
                $persona->setApellidos($params["apellidos"]);
                $personal->setDepartamento($params["departamento"]);
                $em->getConnection()->beginTransaction();
                $em->persist($personal);
                $em->flush();
                $em->getConnection()->commit();
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-miembro_soporte.html.twig');
    }
    
    public function MiembroSoporteSetAction(Request $request){
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
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    }
    
    public function MiembroSoporteDeleteAction(Request $request){
      try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $em = $this->getDoctrine()->getManager();
                $em->getConnection()->beginTransaction();
                $personal = $em->getRepository('GuiasDocentesAppBundle:Personal')->findOneByEmail($params["email"]);
                $em->remove($personal);
                $em->flush();
                $em->getConnection()->commit();
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
    } 

    
    /******************** FIN SET Y DELETE ACTIONS *********************************/


   
// Funciones de JSON

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
    
    public function GetSupportGroupAction(){
        $em = $this->getDoctrine()->getManager();
        $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')
        ->findAll();
        $response = new JsonResponse();
        foreach ($grupos_soporte as $grupo_soporte){
            $grupo_soporte_nombre[]=$grupo_soporte->getNombre();
        }
        $response->setData(array(
            'success' => true, 'data'=>$grupo_soporte_nombre
        ));
        return $response;
    }
    
    
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

    public function getPersonalesAction(){
        $em = $this->getDoctrine()->getManager();
        $response = new JsonResponse();
        $personales = $em->getRepository('GuiasDocentesAppBundle:Personal')->findAll();
        foreach ($personales as $personal){
            $personal_nombre[]=$personal->getEmail();
        }
        $response->setData(array(
            'success' => true, 'data'=>$personal_nombre
        ));
        return $response;
    }
    
    
    public function getNumConsultasByMonthAction(){
        $em = $this->getDoctrine()->getManager();
        // var_dump($year);
        $num_consultasByMoth = $em->getRepository('GuiasDocentesAppBundle:Consulta')
        ->getNumConsultasByMonth('2016');
        // var_dump($num_consultasByMoth);
            // $cbm = [];
        foreach ($num_consultasByMoth as $key => $value) {
            // $cbm[]=array("mes" => $key.'-2016', "valor" => $value); 
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

// Funciones Auxiliares

  
    private function consultantesToString($consultantes){
        $cadena ="";
        foreach ($consultantes as $consultante) {
            $cadena = $cadena.$consultante->getEmail().',';
        }
        return $cadena;
    }
    
}
