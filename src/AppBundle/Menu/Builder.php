<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Description of Builder
 *
 * @author Norman
 */
class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
        $menu->addChild('Relations', array('route' => 'relations'));
        $menu->addChild('Prospects', array('route' => 'prospects'));
        $menu->addChild('Echanges', array('route' => 'echanges'));        
        $menu->addChild('Profil', array('route' => 'sonata_user_profile_show'));
        $menu->addChild('Déconnexion', array('route' => 'sonata_user_security_logout'));
        
//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        
        return $menu;
    }
    
}
