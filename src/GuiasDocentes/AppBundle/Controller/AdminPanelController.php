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
use GuiasDocentes\AppBundle\Entity\Admin;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\HttpFoundation\Session\Session;
use GuiasDocentes\AppBundle\Controller\MailerManagementController;





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
        $personales = $em->getRepository('GuiasDocentesAppBundle:Personal')->findAll();
        $personalesToString = $this->consultantesToString($personales);

        return $this->render('GuiasDocentesAppBundle:AdminPanel:index.html.twig', array('user' => $usr, 'num_consultantes' => $num_consultantes, 'num_consultas' => $num_consultas, 'personal' => $personalesToString));
    }
    
    
    public function groupAction (){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $groupForProfile = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
        ->getAllGroupOrderedByOrden();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:group.html.twig', array('user' => $usr, 'gfps' => $groupForProfile));
    }
    


    public function StaticsAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        // $statics_consultas = $em->getRepository('GuiasDocentesAppBundle:Consulta')->getNumConsultasByMonth('2016');
        // var_dump($this->getNumConsultasByMonthAction());
        $usr= $this->get('security.context')->getToken()->getUser();
        

        return $this->render('GuiasDocentesAppBundle:AdminPanel:statics.html.twig', array('user' => $usr));
        
    }
    
    
    public function pfAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $pfs = $em->getRepository('GuiasDocentesAppBundle:Pf')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:pf.html.twig', array('user' => $usr, 'pfs' => $pfs));    
    }
    
    public function profilesAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $profiles = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:profiles.html.twig', array('user' => $usr, 'perfiles' => $profiles));    
    }
    
    public function SupportGroupAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $grupos_soporte = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:grupos_soporte.html.twig', array('user' => $usr, 'grupos_soporte' => $grupos_soporte));    
    }
    
    public function TematicaSoporteAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $tematicas_soporte = $em->getRepository('GuiasDocentesAppBundle:TematicaSoporte')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:tematica_soporte.html.twig', array('user' => $usr, 'tematicas_soporte' => $tematicas_soporte));    
    }
    
    public function miembroSoporteAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:miembro_soporte.html.twig', array('user' => $usr, 'personales' => $miembros_soporte));    
    }

/***** FIN de REGEX ****/
    
    public function cleanAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $miembros_soporte = $em->getRepository('GuiasDocentesAppBundle:Personal')
        ->findAll();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                $hilos = $em->getRepository('GuiasDocentesAppBundle:Hilo')->findByPersonalEmail($params["personal"]);
                $em->getConnection()->beginTransaction();
                $em->remove($hilos);
                $em->flush();
                $em->getConnection()->commit();
            }else{
                $this->indexAction($request);
            }
        }catch(Exception $e){
            $em->getConnection()->rollback();
            throw $e;
        }
        return $this->render('GuiasDocentesAppBundle:AdminPanel:clean.html.twig', array('user' => $usr, 'personales' => $miembros_soporte));  
    }
    
    
    public function mailerAdminAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        try{
            if ($request->isMethod('POST')){
                $params = $this->getRequest()->request->all();
                // Cargamos el servicio MailerManagement
                $mailerService = $this->get('mailer_management');
                if ($mailerService->sendAdminMessage($params)){
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
                $administrador = $em->getRespository('GuiasDocentesAppBundle:Administrador')->findByEmail($params["reccver-email"]);
                if (isset($administrador)){
                    $params["username"] = $administrador->getUsername();
                    $decoder = new MessageDigestPasswordDecoder('sha512',true,1);
                    $params["password"] = $decoder->decodePassword($administrador->getPassword(), $administrador->getSalt());
                // Cargamos el servicio MailerManagement
                    $mailerService = $this->get('mailer_management');
                    if ($mailerService->sendRecoverMessage($params)){
                        $this->indexAction($request);
                    }
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

    /******************** SETER, DELETES AND CREATES ACTIONS *************************************/
    
    /**                     *
    *       Grupos PF       *
    *                       *
    */
    
    public function createGroupAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-group.html.twig', array('user' => $usr, 'perfiles' => $perfiles));
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
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-admin.html.twig', array('user' => $usr));
    }
    
    /**                     *
    *       Perfiles        *
    *                       *
    */
    
    public function createProfileAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-profile.html.twig', array('user' => $usr));
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
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-pf.html.twig', array('user' => $usr, 'perfiles_grupos' => $p));
    }
    
    // public function ProfileSetAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["nombre"]);
    //             $gshp->setPerfilnombre($perfil);
    //             $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
    //             $gshp->setGruposoporteid($grupo_soporte);
    //             $em->persist($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    // }
    
    // public function ProfileDeleteAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $em->remove($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    // }
    
    
    /**                             *
    *       Grupos Soporte          *
    *                               *
    */
    
    public function createSupportGroupAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-support_group.html.twig', array('user' => $usr, 'perfiles' => $perfiles));
    }
    
    public function SupportGroupSetAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["nombre"]);
    //             $gshp->setPerfilnombre($perfil);
    //             $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
    //             $gshp->setGruposoporteid($grupo_soporte);
    //             $em->persist($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    }
    
    public function SupportGroupDeleteAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $em->remove($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    }    
 
    /**                                 *
    *       Temática Soporte            *
    *                                   *
    */
    
    public function createTematicaSoporteAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-tematica_soporte.html.twig', array('user' => $usr, 'personales' => $personales));
    }
    
    public function TematicaSoporteSetAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["nombre"]);
    //             $gshp->setPerfilnombre($perfil);
    //             $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
    //             $gshp->setGruposoporteid($grupo_soporte);
    //             $em->persist($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    }
    
    public function TematicaSoporteDeleteAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $em->remove($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    }

    /**                                 *
    *       Personal de Soporte         *
    *                                   *
    */
    
    public function createMiembroSoporteAction(Request $request){
        $usr= $this->get('security.context')->getToken()->getUser();
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

        return $this->render('GuiasDocentesAppBundle:AdminPanel:create-miembro_soporte.html.twig', array('user' =>$usr));
    }
    
    public function MiembroSoporteSetAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $perfil =  $em->getRepository('GuiasDocentesAppBundle:Perfil')->findOneByNombre($params["nombre"]);
    //             $gshp->setPerfilnombre($perfil);
    //             $grupo_soporte =  $em->getRepository('GuiasDocentesAppBundle:GrupoSoporte')->findOneById($params["grupo_soporte"]);
    //             $gshp->setGruposoporteid($grupo_soporte);
    //             $em->persist($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
    }
    
    public function MiembroSoporteDeleteAction(Request $request){
    //   try{
    //         if ($request->isMethod('POST')){
    //             $params = $this->getRequest()->request->all();
    //             var_dump($params);die;
    //             $em = $this->getDoctrine()->getManager();
    //             $em->getConnection()->beginTransaction();
    //             $gshp = $em->getRepository('GuiasDocentesAppBundle:GrupoSoporteHasPerfil')->findOneById($params["id_grupo_soporte_perfil"]);
    //             $em->remove($gshp);
    //             $em->flush();
    //             $em->getConnection()->commit();
    //         }
    //     }catch(Exception $e){
    //         $em->getConnection()->rollback();
    //         throw $e;
    //     }
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
