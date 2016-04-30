<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChatType extends AbstractType
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
            ->add('content')
            ->add('prospect', 'entity', array(
                'required' => TRUE,
                'class' => 'AppBundle:Prospect'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Chat'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_chat';
    }
}
