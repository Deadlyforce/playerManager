<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RedFlagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unemployed', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('needy', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('children', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('smoker', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('checkphone', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('boring', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('selfAbsorbed', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('cheapdate', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('snore', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('hygiene', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\RedFlag'
        ));
    }
    
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_redflag';
    }
}
