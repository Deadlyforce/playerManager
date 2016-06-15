<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationshipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
                
        $builder
            ->add('startDate', DateTimeType::class, array(
		'required' => false,
		'label' => 'Start date',
		'model_timezone' => 'Europe/Paris',
		'view_timezone' => 'Europe/Paris',
		'input' => 'datetime',
		'widget' => 'single_text',
		'format' => 'dd-MM-yyyy'                
            ))
            ->add('status', CheckboxType::class, array(
                'required' => false
            ))
            ->add('meeting', CheckboxType::class, array(                
                'required' => false
            ))
            ->add('numclosed', CheckboxType::class, array(
                'required' => false               
            ))
            ->add('kc', CheckboxType::class, array(
                'required' => false              
            ))
            ->add('fc', CheckboxType::class, array(
                'required' => false
            ))
            ->add('crush', CheckboxType::class, array(
                'required' => false
            ))
            ->add('relationshipRank', EntityType::class, array(
                'class' => 'AppBundle:RelationshipRank',
                'choice_translation_domain' => true,
                'choice_label' => function($value, $key, $index){
                    return 'relationship_rank.'.$value;
                }
            ))
            ->add('distance', CheckboxType::class, array(
                'required' => false               
            ))
            ->add('flake', CheckboxType::class, array(
                'required' => false
            ))
            ->add('about', TextareaType::class, array(
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Save changes'
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Relationship'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_relationship';
    }
}
