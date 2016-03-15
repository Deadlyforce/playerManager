<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Form\PhotoType;

class ProspectType extends AbstractType
{   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $builder
            ->add('pseudo', TextType::class, array(
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
            ->add('prenom', TextType::class, array(
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
            ->add('nom', TextType::class, array(
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
            ->add('age', ChoiceType::class, array(
                'choices' => $this->getAgeBracket(),
                'choices_as_values' => true,
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('ville', TextType::class, array(
                'required' => FALSE, 
                'attr' => array(
                    'placeholder' => 'Paris',
                    'class' => 'form-input-ville'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('arrondissement', ChoiceType::class, array(
                'required' => FALSE,
                'choices' => $this->getArrondissements(), 
                'choices_as_values' => true,
                'attr' => array(                    
                    'class' => 'form-input'
                    ),
                'row_attr' => array(
                    'class' => 'form_row row_arrondissement'
                )
            ))
            ->add('pays', TextType::class, array(
                'required' => false, 
                'attr' => array(
                    'class' => 'form-input'                    
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numero', TextType::class, array(
                'required' => false,
                'label' => 'Tel portable',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numeroDom', TextType::class, array(
                'required' => false,
                'label' => 'Tel Domicile',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('numeroEtranger', TextType::class, array(
                'required' => false, 
                'label' => 'Tel étranger',
                'attr' => array(
                    'class' => 'form-input'
                ),
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('source', EntityType::class, array(
                'class' => 'AppBundle:Source',
                'row_attr' => array(
                    'class' => 'form_row'
                )
            ))
            ->add('photos', CollectionType::class, array(
                'entry_type' => new PhotoType(),
                'entry_options' => array(
                    'required' => false,
                    'row_attr' => array(
                        'class' => 'form_row'
                    )
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('dateCreation', DateTimeType::class, array(
		'required' => false,
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Prospect'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_prospect';
    }
    
    /**
     * Returns age bracket
     * 
     * @return Array
     */
    private function getAgeBracket()
    {
        // Chargement de la tranche d'âges
        for($i=18; $i<=50; $i++){
            $ageBracket[$i] = $i;
        }
        
        return $ageBracket;
    }
    
    /**
     * Returns Paris arrondissements
     * 
     * @return Array
     */
    private function getArrondissements()
    {
        // Chargement de la tranche d'âges
        for($i=1; $i<=20; $i++){
            $parisArrondissements[$i] = $i;
        }
        
        return $parisArrondissements;
    } 
}
