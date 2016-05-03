<?php

namespace GuiasDocentes\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PerfilType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('perfil', 'choice', array('choices' => array ()))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuiasDocentes\AppBundle\Entity\Perfil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'guiasdocentes_appbundle_perfil';
    }
}
