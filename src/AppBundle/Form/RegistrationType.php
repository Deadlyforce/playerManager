<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Description of RegistrationType
 *
 * @author Norman
 */
class RegistrationType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {            
        parent::buildForm($builder, $options);
        
        $builder
            ->add('gender', ChoiceType::class, array(
                'label' => 'app.register.form.gender',
                'required' => true,
                'choices' => array(
                    'app.register.form.male' => 1,
                    'app.register.form.female' => 2
                )                
            ))
//            ->add('locale', ChoiceType::class, array(
//                'required' => true,
//                'choices' => array(
//                    'English' => 'en',
//                    'French' => 'fr'
//                )
//            ))
            ->add('captcha', CaptchaType::class, array(
                'label' => 'app.register.form.captcha'
            ));
    }
            
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_registration';
    }    
}
