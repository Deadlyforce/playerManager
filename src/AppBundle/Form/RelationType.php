<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RelationType extends AbstractType
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
            ->add('rencontreCount', 'integer', array(
                'required' => FALSE,
                'label' => 'Nombre de rencontres'
            ))
            ->add('numero', 'checkbox', array(
                'required' => FALSE,
                'label' => 'Numéro acquis',
                'data' => FALSE
            ))
            ->add('kc', 'checkbox', array(
                'required' => FALSE,
                'label' => 'KC',
                'data' => FALSE
            ))
            ->add('fc', 'checkbox', array(
                'required' => FALSE,
                'label' => 'FC',
                'data' => FALSE
             ))
            ->add('categorie', 'entity', array(
                'class' => 'AppBundle:Categorie'
            ))
            ->add('distance', 'checkbox', array(
                'required' => FALSE,
                'label' => 'Problème de distance',
                'data' => FALSE
            ))
            ->add('flake', 'checkbox', array(
                'required' => FALSE
            ))
            ->add('commentaire','textarea', array(
                'required' => FALSE,
                'label_attr' => array(
                    'class' => 'appbundle_relation_commentaire'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Relation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_relation';
    }
}