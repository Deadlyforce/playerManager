<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProspectType extends AbstractType
{
    protected $ageBracket;
    protected $parisArrondissements;
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        // Chargement de la tranche d'âges
        for($i=18; $i<=50; $i++){
            $ageBracket[$i] = $i;
        }
        
        // Chargement de la tranche d'âges
        for($i=1; $i<=20; $i++){
            $parisArrondissements[$i] = $i;
        }
        
        $builder
            ->add('pseudo', 'text', array(
                'required' => FALSE, 
                'label_attr' => array(
                    'class' => 'control-label'
                ), 
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('prenom', 'text', array(
                'required' => TRUE, 
                'label' => 'Prénom', 
                'label_attr' => array(
                    'class' => 'control-label'
                ), 
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('nom', 'text', array(
                'required' => FALSE, 
                'label' => 'Nom', 
                'label_attr' => array(
                    'class' => 'control-label'
                ), 
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('age', 'choice', array(
                'choices' => $ageBracket,                
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('ville', 'text', array(
                'required' => FALSE, 
                'attr' => array(
                    'placeholder' => 'Paris',
                    'class' => 'form-input-ville'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('arrondissement', 'choice', array(
                'required' => FALSE,
                'choices' => $parisArrondissements,                
                'attr' => array(                    
                    'class' => 'form-input'
                    ),
                'row_attr' => array(
                    'class' => 'form_row row_arrondissement'
                )
            ))
            ->add('pays', 'text', array(
                'required' => TRUE, 
//                'data' => 'France',
                'attr' => array(
                    'class' => 'form-input'                    
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numero', 'text', array(
                'required' => FALSE,
                'label' => 'Tel portable',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numeroDom', 'text', array(
                'required' => FALSE,
                'label' => 'Tel Domicile',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numeroEtranger', 'text', array(
                'required' => FALSE, 
                'label' => 'Tel étranger',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('source', 'entity', array(
                'class' => 'AppBundle:Source',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('file', 'file', array(
                'required' => FALSE, 
                'label' => 'Photo principale',
                'attr' => array(
                    'class' => 'form-input-photoPrincipale'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('dateCreation', 'datetime', array(
		'required' => FALSE,
		'label' => 'Date de création: ',
		'model_timezone' => 'Europe/Paris',
		'view_timezone' => 'Europe/Paris',
		'input' => 'datetime',
		'widget' => 'single_text',
		'format' => 'dd-MM-yyyy',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('relation', new RelationType(), array(
                
            ))
                
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prospect'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_prospect';
    }
}
