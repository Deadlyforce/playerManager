<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
            ->add('orderby', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    'app.contact.list.orderby.rating' => 'rating',                    
                    'app.contact.list.orderby.redflag' => 'redflag'                   
                )
            ))
            ->add('sex', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    'app.contact.list.filter.choices.sex.yes' => 1,                    
                    'app.contact.list.filter.choices.sex.no' => 0                   
                )
            ))                                  
            ->add('relationshipLevel', ChoiceType::class, array(
                'required' => false,
                'choices' => array(
                    'relationship_rank.chatting' => 1,                    
                    'relationship_rank.one_night_stand' => 2,                    
                    'relationship_rank.sex_friend' => 3,                    
                    'relationship_rank.dating' => 4,                    
                    'relationship_rank.open_relationship' => 5,                    
                    'relationship_rank.long_term_relationship' => 6,                    
                )
            ))                                  
        ;
    }    
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Option'
        ));
    }
   
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_options';
    }
}
