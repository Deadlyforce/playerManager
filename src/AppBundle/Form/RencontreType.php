<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RencontreType extends AbstractType
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
                'date_format' => 'dd MM yyyy',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('lieu', TextType::class, array(
                'label' => 'Lieu',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('duree', IntegerType::class, array(
                'label' => 'Durée',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('depenses_total', IntegerType::class, array(
                'label' => 'Total dépenses',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('changement_lieu', CheckboxType::class, array(
                'label' => 'Changement de lieu',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('liste_lieux')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rencontre'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_rencontre';
    }
}
