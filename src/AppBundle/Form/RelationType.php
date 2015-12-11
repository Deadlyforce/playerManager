<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
                
        $builder
            ->add('statut', ChoiceType::class, array(
                'required' => TRUE,
                'choices' => array(
                    1 => 'On',
                    0 => 'Off'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
                'data' => 1
            ))
            ->add('rencontre', ChoiceType::class, array(
                'required' => TRUE,
                'choices' => array(
                    1 => 'Oui',
                    0 => 'Non'
                ),
                'expanded' => TRUE,
                'multiple' => FALSE,
                'data' => 0
            ))
            ->add('rencontreCount', IntegerType::class, array(
                'required' => FALSE,
                'label' => 'Nombre de rencontres'
            ))
            ->add('numero', CheckboxType::class, array(
                'required' => FALSE,
                'label' => 'Numéro acquis',
                'data' => FALSE
            ))
            ->add('kc', CheckboxType::class, array(
                'required' => FALSE,
                'label' => 'KC',
                'data' => FALSE
            ))
            ->add('fc', CheckboxType::class, array(
                'required' => FALSE,
                'label' => 'FC',
                'data' => FALSE
             ))
            ->add('categorie', EntityType::class, array(
                'class' => 'AppBundle:Categorie'
            ))
            ->add('distance', CheckboxType::class, array(
                'required' => FALSE,
                'label' => 'Problème de distance',
                'data' => FALSE
            ))
            ->add('flake', CheckboxType::class, array(
                'required' => FALSE
            ))
            ->add('commentaire', TextareaType::class, array(
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Relation'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_relation';
    }
}
