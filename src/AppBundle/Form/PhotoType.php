<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Description of PhotoType
 *
 * @author Norman
 */
class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        
        $builder   
            ->add('file', FileType::class, array(
                'label' => false                
                )
            )
            ->add('selected', CheckboxType::class, array(
                'label' => "Make primary",
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Photo'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_photo';
    }
}
