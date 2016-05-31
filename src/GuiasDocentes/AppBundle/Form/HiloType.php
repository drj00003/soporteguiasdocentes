<?php

namespace GuiasDocentes\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GuiasDocentes\AppBundle\Form\ConsultanteType;
use GuiasDocentes\AppBundle\Entity\Personal;
use GuiasDocentes\AppBundle\Entity\PersonalRepository;



class HiloType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('consultanteemail', new ConsultanteType(), array ('label' => false))
            ->add('personalemail', 'entity', array(
                'label' => 'Personal de Soporte',
                'class' => 'GuiasDocentes\AppBundle\Entity\Personal',
                'property' => 'Enunciado',
                'by_reference' => 'false',
                'query_builder' => function(PersonalRepository $pr) {
                    $query= $pr->createQueryBuilder('u')
                    ;
                    return $query;
                },
                // 'query_builder' => function(PersonalRepository $pr) {
                //     return $pr->getPersonalOrdered3();
                // },
                'empty_value' => 'Elija una temática para su consulta:',
                ))
        ;
    }
// Consulta SQL
// SELECT p.* FROM personal p INNER JOIN tematica_soporte ts ON ts.personalEmail = p.email ORDER BY ts.orden

// Necesito modificar la consulta para que haga un join con la tabla tematica_soporte donde email (personal) y email_soporte (personal_soporte)
// order by orden (personal_soporte)

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GuiasDocentes\AppBundle\Entity\Hilo',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'guiasdocentes_appbundle_hilo';
    }
}
