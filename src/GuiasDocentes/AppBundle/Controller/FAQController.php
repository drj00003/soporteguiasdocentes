<?php

namespace GuiasDocentes\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FAQController extends Controller
{
  

    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('GuiasDocentesAppBundle:Perfil');
        $perfiles = $repository->findAll();
        usort($perfiles, array($this, "comparePerfiles"));
        return $this->render('GuiasDocentesAppBundle:FAQ:index.html.twig', array('perfiles' => $perfiles));
    }
    
    private function comparePerfiles($p1, $p2){
        if ( $p1->getOrden() > $p2->getOrden() ){
            return 1;
        }else{
            return -1;
        }
    }  
    
}
