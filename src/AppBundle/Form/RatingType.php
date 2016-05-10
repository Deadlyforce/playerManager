<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RatingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attractiveness', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('socialStatus', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('senseHumor', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('cooking', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('kissing', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('sex', IntegerType::class, array(
                'required' => false,
                'attr' => array(
                    'min' => 0,
                    'max' => 5
                )
            ))
            ->add('average', IntegerType::class, array(
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
            'data_class' => 'AppBundle\Entity\Rating'
        ));
    }
    
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_rating';
    }
}
