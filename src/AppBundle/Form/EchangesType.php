<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EchangesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prospects_id')
            ->add('date', 'date', array('required' => TRUE))
            ->add('contenu')
            ->add('prospects', 'entity', array(
                'required' => TRUE,
                'class' => 'AppBundle:Prospects'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Echanges'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_echanges';
    }
}
