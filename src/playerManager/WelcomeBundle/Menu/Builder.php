<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Builder
 *
 * @author Norman
 */

namespace playerManager\WelcomeBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;


class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
        $menu->addChild('Relations', array('route' => 'relations'));
        $menu->addChild('Prospects', array('route' => 'prospects'));
        $menu->addChild('Echanges', array('route' => 'echanges'));
        $menu->addChild('Déconnexion', array('route' => 'fos_user_security_logout'));
        
//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        
        return $menu;
    }
    
}
