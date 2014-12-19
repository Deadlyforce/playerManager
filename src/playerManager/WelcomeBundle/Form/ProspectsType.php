<?php

namespace playerManager\WelcomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProspectsType extends AbstractType
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
                'required' => TRUE, 
                'label_attr' => array(
                    'class' => 'control-label'
                    ), 
                'attr' => array(
                    'class' => 'form-control form-input'
                    )               
                ))
            ->add('prenom', 'text', array(
                'required' => FALSE, 
                'label' => 'Prénom', 
                'label_attr' => array(
                    'class' => 'control-label'
                    ), 
                'attr' => array(
                    'class' => 'form-control form-input'
                    )
                ))
            ->add('nom', 'text', array(
                'required' => FALSE, 
                'label' => 'Nom', 
                'label_attr' => array(
                    'class' => 'control-label'
                    ), 
                'attr' => array(
                    'class' => 'form-control form-input'
                    )
                ))
            ->add('age', 'choice', array(
                'choices' => $ageBracket,
                'attr' => array(
                    'class' => 'form-control form-input-age',                       
                ),
                'data' => 22
            ))
            ->add('ville', 'text', array(
                'required' => FALSE, 
                'attr' => array(
                    'placeholder' => 'Paris',
                    'class' => 'form-control form-input-ville'
                    )
                ))
            ->add('arrondissement', 'choice', array(
                'required' => FALSE,
                'choices' => $parisArrondissements,                
                'attr' => array(                    
                    'class' => 'form-control form-input'
                    ),
                'row_attr' => array(
                    'class' => 'row_arrondissement'
                ),
                'data' => 1
                ))
            ->add('pays', 'text', array(
                'required' => TRUE, 
                'attr' => array(
                    'class' => 'form-control form-input',
                    'value' => 'France'
                    )
                ))
            ->add('numero', 'text', array(
                'label' => 'Numéro',
                'attr' => array(
                    'class' => 'form-control form-input'
                    )
                ))
            ->add('numeroEtranger', 'text', array(
                'required' => FALSE, 
                'label' => 'Numéro étranger',
                'attr' => array(
                    'class' => 'form-control form-input'
                    )
                ))
            ->add('site', 'choice', array(
                'choices' => array(
                    'adopteUnMec' => 'AdopteUnMec', 
                    'okcupid' => 'OKCupid'
                    ),
                'required' => TRUE,
                'attr' => array(
                    'class' => 'form-control form-input-site'
                    )
                ))
            ->add('file', 'file', array(
                'required' => FALSE, 
                'label' => 'Photo principale',
                'attr' => array(
                    'class' => 'form-control form-input-photoPrincipale'
                    )
                ))
//            ->add('relations')
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
