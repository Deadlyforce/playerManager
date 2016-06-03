<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('unemployed', CheckboxType::class, array(
                'required' => false     
            ))
            ->add('needy', CheckboxType::class, array(
                'required' => false
            ))
            ->add('children', CheckboxType::class, array(
                'required' => false
            ))
            ->add('smoker', CheckboxType::class, array(
                'required' => false
            ))
//            ->add('checkphone', ChoiceType::class, array(
//                'required' => false,
//                'choices' => array(
//                    "app.redflag.form.level1" => 1,
//                    "app.redflag.form.level2" => 2,
//                    "app.redflag.form.level3" => 3,
//                    "app.redflag.form.level4" => 4,
//                    "app.redflag.form.level5" => 5
//                )
//            ))           
//            ->add('selfAbsorbed', ChoiceType::class, array(
//                'required' => false,
//                'choices' => array(
//                    "app.redflag.form.level1" => 1,
//                    "app.redflag.form.level2" => 2,
//                    "app.redflag.form.level3" => 3,
//                    "app.redflag.form.level4" => 4,
//                    "app.redflag.form.level5" => 5
//                )
//            ))
//            ->add('cheapdate', ChoiceType::class, array(
//                'required' => false,
//                'choices' => array(
//                    "app.redflag.form.level1" => 1,
//                    "app.redflag.form.level2" => 2,
//                    "app.redflag.form.level3" => 3,
//                    "app.redflag.form.level4" => 4,
//                    "app.redflag.form.level5" => 5
//                )
//            ))
            ->add('snore', CheckboxType::class, array(
                'required' => false
            ))
            ->add('hygiene', CheckboxType::class, array(
                'required' => false
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
