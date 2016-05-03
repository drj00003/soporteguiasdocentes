<?php

namespace GuiasDocentes\AppBundle\Controller;
use GuiasDocentes\AppBundle\Entity\Grupo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FAQController extends Controller
{
  

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $perfiles = $em->getRepository('GuiasDocentesAppBundle:Perfil')
        ->getAllOrderProfiles();
        return $this->render('GuiasDocentesAppBundle:FAQ:index.html.twig', array('perfiles' => $perfiles));
    }
    
    public function gfaqAction(){
        $perfil = $_POST['perfil'];
        if ($perfil == null){
            return null;
        }else{
            $em = $this->getDoctrine()->getManager();
            $idgrupos = $em->getRepository('GuiasDocentesAppBundle:PerfilGrupoOrder')
            ->getDistinctGroupsByPerfilOrdered($perfil);
            if (!$idgrupos) {
                 throw $this->createNotFoundException(
                    'No existen gurpos para el perfil seleccionado '.$perfil);
            }else{
                // var_dump($grupos);
                // Hasta aquí tenemos los (ids) grupos de los cuales en twig podemos sacar los nombres
                // Debemos de sacar el objeto completo y hacer un collection
                // Debemos de con el id del grupo tambien hacer un collection 
                
                foreach ($idgrupos as $idgrupo){
                    $grupos[]=$em->getRepository('GuiasDocentesAppBundle:Grupo')
                    ->getGrupoById($idgrupo[1]);
                    $collectionPF[$idgrupo[1]] = $em->getRepository('GuiasDocentesAppBundle:Pf')
                    ->getCollectionPFByGroupOrdered($idgrupo[1]);
                }
                return $this->render('GuiasDocentesAppBundle:FAQ:gfaq.html.twig', array('perfil' => $perfil, 'grupos'=> $grupos, 'PF' => $collectionPF));
            }
        }
    }

    
    private function comparePerfiles($p1, $p2){
        if ( $p1->getOrden() > $p2->getOrden() ){
            return 1;
        }else{
            return -1;
        }
    }  
    

    
}
