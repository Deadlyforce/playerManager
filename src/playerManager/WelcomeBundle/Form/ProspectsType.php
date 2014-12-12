<?php

namespace playerManager\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProspectsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('prenom')
            ->add('nom')
            ->add('age')
            ->add('ville')
            ->add('pays')
            ->add('numero')
            ->add('numeroEtranger')
            ->add('site')
            ->add('photoPrincipale')
            ->add('relations')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'playerManager\WelcomeBundle\Entity\Prospects'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'playermanager_welcomebundle_prospects';
    }
}
