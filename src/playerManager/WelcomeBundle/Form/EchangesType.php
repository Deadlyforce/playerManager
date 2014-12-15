<?php

namespace playerManager\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EchangesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prospects_id')
            ->add('date', 'date', array('required' => TRUE))
            ->add('contenu')
            ->add('prospects', 'entity', array(
                'required' => TRUE,
                'class' => 'playerManagerWelcomeBundle:Prospects'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'playerManager\WelcomeBundle\Entity\Echanges'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'playermanager_welcomebundle_echanges';
    }
}
