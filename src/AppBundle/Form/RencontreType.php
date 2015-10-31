<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RencontreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'datetime', array(
                'label' => 'Date',
                'input' => 'datetime',
        'widget' => 'single_text',
        'date_format' => 'dd MM yyyy',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('lieu', 'text', array(
                'label' => 'Lieu',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('duree', 'integer', array(
                'label' => 'Durée',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('depenses_total', 'integer', array(
                'label' => 'Total dépenses',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('changement_lieu', 'checkbox', array(
                'label' => 'Changement de lieu',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('liste_lieux')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rencontre'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_rencontre';
    }
}
