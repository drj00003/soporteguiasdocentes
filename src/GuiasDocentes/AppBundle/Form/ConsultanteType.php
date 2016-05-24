<?php

namespace GuiasDocentes\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\Consultante;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ConsultanteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        // $em = $this->getDoctrine()->getManager();
        // $personales = $em->getRepository('GuiasDocentesAppBundle:Consultante')
        // ->findByEmail($data['email']);
        $builder
            ->add('nombre', 'text', array('label'=> 'Nombre'))
            ->add('apellidos', 'text', array('label'=> 'Apellidos'))
            ->add('email', 'email', array('label'=> 'Email'))
        ;
        // $builder
        //     ->addEventListener(
        //         FormEvents::PRE_BIND,
        //         function(FormEvent $event) {
        //             $data = $event->getData();
        //             $form = $event->getForm();
        //             if (isset($data['email']) && $data['email']) {
        //                     $em = $this->getDoctrine()->getManager();
        //                     $consultante = $em->getRepository('GuiasDocentesAppBundle:Consultante')
        //                     ->findByEmail($data['email']);
        //                     if ($consultante != null){
        //                         var_dump("ya existe");
        //                     }
        //                 ;
        //             }
        //         }
        //     )
        // ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuiasDocentes\AppBundle\Entity\Consultante',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'guiasdocentes_appbundle_consultante';
    }
}
