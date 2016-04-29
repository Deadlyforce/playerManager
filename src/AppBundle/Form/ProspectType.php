<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('nickname', TextType::class, array(
                'required' => false                                
            ))
            ->add('firstname', TextType::class, array(
                'required' => true, 
                'label' => 'First Name'                
            ))
            ->add('lastname', TextType::class, array(
                'required' => FALSE, 
                'label' => 'Last Name'                
            ))
            ->add('age', ChoiceType::class, array(
                'choices' => $this->getAgeBracket(),
                'choices_as_values' => true                
            ))
            ->add('address', TextType::class, array(
                'required' => false                
            ))
            ->add('city', TextType::class, array(
                'required' => false                
            ))
            ->add('parisDistrict', ChoiceType::class, array(
                'required' => false,
                'choices' => $this->getParisDistricts(), 
                'choices_as_values' => true                
            ))
            ->add('country', TextType::class, array(
                'required' => false                                
            ))
            ->add('cellNumber', TextType::class, array(
                'required' => false,
                'label' => 'Cell number'                
            ))
            ->add('homeNumber', TextType::class, array(
                'required' => false,
                'label' => 'Home number'                
            ))
            ->add('job', TextType::class, array(
                'required' => false,
                'label' => 'Job'                
            ))
            ->add('source', EntityType::class, array(
                'class' => 'AppBundle:Source'                
            ))
            ->add('photos', CollectionType::class, array(
                'label' => false,
                'entry_type' => PhotoType::class,
                'entry_options' => array(
                    'required' => false                    
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))            
            ->add('relationship', RelationshipType::class, array(

            )) 
            ->add('submit', SubmitType::class, array(
                'label' => 'Save changes'
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
        for($i=18; $i<=50; $i++){
            $ageBracket[$i] = $i;
        }
        
        return $ageBracket;
    }
    
    /**
     * Returns Paris Districts
     * 
     * @return Array
     */
    private function getParisDistricts()
    {        
        for($i=1; $i<=20; $i++){
            $paris_districts[$i] = $i;
        }
        
        return $paris_districts;
    } 
}
