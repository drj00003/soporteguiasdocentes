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
use GuiasDocentes\AppBundle\Entity\GrupoRepository;
use GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura;
use GuiasDocentes\AppBundle\Form\HiloType;
use GuiasDocentes\AppBundle\Form\ConsultaType;
use GuiasDocentes\AppBundle\Form\RespuestaType;
use GuiasDocentes\AppBundle\Form\ConsultaHasAsignaturaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuiasDocentes\AppBundle\Entity\Admin;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;





class AdminPanelController extends Controller
{
  
    public function indexAction(Request $request)
    {
        $usr= $this->get('security.context')->getToken()->getUser();

        return $this->render('GuiasDocentesAppBundle:AdminPanel:index.html.twig', array('user' => $usr));
    }
    
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
    
    public function groupAction (){
        $usr= $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $groupForProfile = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
        ->getAllGroupOrderedByOrden();
        return $this->render('GuiasDocentesAppBundle:AdminPanel:group.html.twig', array('user' => $usr, 'gfps' => $groupForProfile));
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
    
}
