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
            // ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            //     $client = $event->getData();
            //     $form = $event->getForm();
        
                // if (!$user) {
                //     return;
                // }
        
                // Check whether the user has chosen to display his email or not.
                // If the data was submitted previously, the additional value that is
                // included in the request variables needs to be removed.
            //     if (true === ctype_alpha($user['apellidos'])) {
            //         $form->add('email', EmailType::class);
            //     } else {
            //         unset($user['email']);
            //         $event->setData($user);
            //     }
            // })
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
