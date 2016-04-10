<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'label' => 'Date',
                'input' => 'datetime',
                'widget' => 'single_text',
                'date_format' => 'dd MM yyyy'                
            ))
            ->add('place', TextType::class, array(
                'label' => 'Place'
            ))
            ->add('duration', IntegerType::class, array(
                'label' => 'Duration'                
            ))
            ->add('expenses', IntegerType::class, array(
                'label' => 'Total expenses'                
            ))
            ->add('venueChange', CheckboxType::class, array(
                'label' => 'Venue change ?'                
            ))
            ->add('venuesList')
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
