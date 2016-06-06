<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\VenueType;

class EncounterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, array(                                   
                'required' => true,		
		'model_timezone' => 'Europe/Paris',
		'view_timezone' => 'Europe/Paris',
		'input' => 'datetime',
		'widget' => 'single_text',
		'format' => 'dd-MM-yyyy HH:mm'
            ))
            ->add('place', TextType::class, array(
                'required' => false
            ))
            ->add('duration', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 12
                )                
            ))
            ->add('expenses', IntegerType::class, array(
                'required' => false,                
                'attr' => array(
                    'min' => 0,
                    'max' => 5000
                )         
            ))
            ->add('venueChange', CheckboxType::class, array(
                'required' => false
            ))
            ->add('venues', CollectionType::class, array(
                'entry_type' => VenueType::class,
                'entry_options' => array(
                    'required' => false                    
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('submit', SubmitType::class, array(
                
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Encounter'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_encounter';
    }
}
