<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RedFlagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('unemployed', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('needy', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('children', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('smoker', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('checkphone', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('boring', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('selfAbsorbed', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('cheapdate', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('snore', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))
            ->add('hygiene', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    "app.redflag.form.level1" => 1,
                    "app.redflag.form.level2" => 2,
                    "app.redflag.form.level3" => 3,
                    "app.redflag.form.level4" => 4,
                    "app.redflag.form.level5" => 5
                )
            ))            
        ;
//        $builder
//            ->add('unemployed', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('needy', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('children', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('smoker', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('checkphone', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('boring', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('selfAbsorbed', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('cheapdate', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('snore', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))
//            ->add('hygiene', IntegerType::class, array(
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 5
//                )
//            ))            
//        ;
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
