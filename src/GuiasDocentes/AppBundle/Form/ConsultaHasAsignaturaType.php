<?php

namespace GuiasDocentes\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConsultaHasAsignaturaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('consulta', new ConsultaType(), array ('label' => false))
            ->add('asignaturaCodigo', new AsignaturaType(), array ('label' => false, 'required' => false))
            ->add('save', 'submit', array('label' => 'Enviar', 'attr' => array ('class' => 'btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuiasDocentes\AppBundle\Entity\ConsultaHasAsignatura',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'guiasdocentes_appbundle_consultahasasignatura';
    }
}
