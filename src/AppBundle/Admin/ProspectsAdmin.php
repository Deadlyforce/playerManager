<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use AppBundle\Form\RelationsType;

/**
 * Description of managerAdmin
 *
 * @author Norman
 */
class ProspectsAdmin extends Admin{
    
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('title', 'text', array('label' => 'Post Title'))
//            ->add('author', 'entity', array('class' => 'AppBundle\Entity\User'))
//            ->add('body') //if no type is specified, SonataAdminBundle tries to guess it
            ->add('pseudo')
            ->add('prenom')
            ->add('nom')
            ->add('age')
            ->add('ville')
            ->add('pays')
            ->add('numero')
            ->add('numero_etranger', 'text', array('required' => FALSE))
            ->add('numero_dom', 'text', array('required' => FALSE))
            ->add('site')
            ->add('photo_principale', 'text')
            ->add('arrondissement')
            ->add('date_creation', 'datetime')
            ->add('relations', new RelationsType())
        ;
    }

//    // Fields to be shown on filter forms
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add('pseudo')
//            ->add('prenom')
//            ->add('nom')
//            ->add('age')
//            ->add('ville')
//            ->add('pays')
//            ->add('numero')
//            ->add('numero_etranger', 'doctrine_orm_string')
//            ->add('numero_dom', 'doctrine_orm_string')
//            ->add('site')
//            ->add('photo_principale', 'doctrine_orm_string')
//            ->add('arrondissement')
//            ->add('relations_id', 'doctrine_orm_model')
////            ->add('date_creation', 'doctrine_orm_datetime')
//        ;
//    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('pseudo')
            ->addIdentifier('prenom', 'text', array(
                'route' => array('name' => 'show')
            ))
            ->add('nom')
            ->add('age')
            ->add('ville')
            ->add('pays')
            ->add('numero')
            ->add('numero_etranger', 'text')
            ->add('numero_dom')
            ->add('site')
            ->add('photo_principale')
            ->add('arrondissement')
            ->add('relations', 'integer')
            ->add('date_creation', 'datetime')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array()
                )
            ))
        ;
    }
    
    protected function configureShowFields(ShowMapper $showMapper) 
    {
        $showMapper
            ->add('pseudo')
            ->add('prenom')
            ->add('nom')
            ->add('age')
            ->add('ville')
            ->add('pays')
            ->add('numero')
            ->add('numero_etranger')
            ->add('numero_dom')
            ->add('site')
            ->add('photo_principale')
            ->add('arrondissement')
            ->add('relations', 'integer')
            ->add('date_creation', 'datetime')
        ;
    }
}
