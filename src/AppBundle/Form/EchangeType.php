<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EchangeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prospect_id')
            ->add('date', 'date', array('required' => TRUE))
            ->add('contenu')
            ->add('prospect', 'entity', array(
                'required' => TRUE,
                'class' => 'AppBundle:Prospect'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Echange'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_echange';
    }
}
