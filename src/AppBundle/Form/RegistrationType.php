<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

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
        
        $builder->add('captcha', 'captcha', array(
            'label' => 'Visual confirmation '
        ));
    }
    
    public function getName() 
    {
        return 'appbundle_user_registration';
    }
}
