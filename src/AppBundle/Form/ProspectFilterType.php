<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProspectFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "Active" => 1,                    
                    "Inactive" => 0,                    
                )
            ))                                  
            ->add('sex', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "Happened" => 1,                    
                    "Didn't happen" => 0                   
                )
            ))                                  
            ->add('relationshipLevel', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "Chatting" => 1,                    
                    "One Night Stand" => 2,                    
                    "Fuck friend" => 3,                    
                    "Dating" => 4,                    
                    "Open relationship" => 5,                    
                    "Monogamous Relationship" => 6,                    
                )
            ))                                  
        ;
    }    
   
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_prospect_filter';
    }
}
