<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Gregwar\CaptchaBundle\Type\CaptchaType;

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
        
        $builder->add('captcha', CaptchaType::class, array(
            'label' => 'Visual confirmation '
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
