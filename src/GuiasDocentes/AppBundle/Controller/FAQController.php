<?php

namespace GuiasDocentes\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FAQController extends Controller
{
    public function indexAction()
    {
        $name = 'David';
        return $this->render('GuiasDocentesAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
