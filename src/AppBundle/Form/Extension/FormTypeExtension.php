<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;

/**
 * Class FormTypeExtension
 * @package AppBundle\Form\Extension
 */
class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * Extend the form type which all other types extend
     * 
     * @return string The name of the type being extended
     */
    public function getExtendedType() 
    {
        return 'form';
    }
    
    /**
     * Add the extra 'row_attr' option
     * 
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) 
    {
        parent::setDefaultOptions($resolver);
        
        $resolver->setDefaults(array(
            'row_attr' => array()
        ));
    }
    
    /**
     * Pass the set 'row_attr' options to the view
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(\Symfony\Component\Form\FormView $view, \Symfony\Component\Form\FormInterface $form, array $options) 
    {
        parent::buildView($view, $form, $options);
        
        $view->vars['row_attr'] = $options['row_attr'];
    }
}

