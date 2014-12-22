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
            ->add('statut', 'choice', array(
                'required' => TRUE,
                'choices' => array(
                    1 => 'On',
                    0 => 'Off'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
                'data' => 1
            ))
            ->add('rencontre', 'choice', array(
                'required' => TRUE,
                'choices' => array(
                    1 => 'Oui',
                    0 => 'Non'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
                'data' => 0
            ))
            ->add('rencontreDate', 'datetime', array(
                'required' => FALSE,
                'label' => 'Date de la rencontre: ',
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris',
                'input' => 'datetime',
                'widget' => 'choice',
                'date_format' => 'dd MM yyyy',
                'data' => new \DateTime('', new \DateTimeZone('Europe/Paris'))
            ))
            ->add('rencontreCount')
            ->add('numero')
            ->add('kc')
            ->add('fc')
            ->add('relType')
            ->add('distance')
            ->add('flake')
            ->add('commentaire')
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
