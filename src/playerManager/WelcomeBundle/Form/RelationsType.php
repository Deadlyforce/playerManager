<?php

namespace playerManager\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statut')
            ->add('rencontre')
            ->add('rencontreDate')
            ->add('rencontreCount')
            ->add('numero')
            ->add('kc')
            ->add('fc')
            ->add('relType')
            ->add('distance')
            ->add('flake')
            ->add('commentaire')
            ->add('prospects')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'playerManager\WelcomeBundle\Entity\Relations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'playermanager_welcomebundle_relations';
    }
}
