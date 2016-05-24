<?php

namespace GuiasDocentes\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GuiasDocentes\AppBundle\Form\HiloType;

class ConsultaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hiloid', new HiloType(), array ('label' => false))
            ->add('texto','textarea', array ('label' => 'Consulta'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuiasDocentes\AppBundle\Entity\Consulta',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        // return 'guiasdocentes_appbundle_consulta';
        return 'consulta';
    }
}
