<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                'label' => 'Relationship status',
                'required' => false
            ))
            ->add('meeting', CheckboxType::class, array(
                'label' => 'Have you met ?',
                'required' => false
            ))
            ->add('meetingCount', IntegerType::class, array(
                'required' => false,
                'label' => 'Meeting count',
                'attr' => array(
                    'min' => 0,
                    'max' => 100
                )
            ))
            ->add('numclosed', CheckboxType::class, array(
                'required' => false,
                'label' => 'Phone number ?'                
            ))
            ->add('kc', CheckboxType::class, array(
                'required' => false,
                'label' => 'Have you kissed ?'                
            ))
            ->add('fc', CheckboxType::class, array(
                'required' => false,
                'label' => 'Did you have sex ?'
             ))
            ->add('relationshipRank', EntityType::class, array(
                'class' => 'AppBundle:RelationshipRank'
            ))
            ->add('distance', CheckboxType::class, array(
                'required' => FALSE,
                'label' => 'Problème de distance',
                'data' => FALSE
            ))
            ->add('flake', CheckboxType::class, array(
                'required' => FALSE
            ))
            ->add('about', TextareaType::class, array(
                'label' => 'About',
                'required' => false,
                'label_attr' => array(
                    'class' => 'appbundle_relation_about'
                )
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
