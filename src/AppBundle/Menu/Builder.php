<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Description of Builder
 *
 * @author Norman
 */
class Builder
{
    use ContainerAwareTrait;
    
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
        $menu->addChild('Relations', array('route' => 'relation'));
        $menu->addChild('Prospects', array('route' => 'prospect'));
        $menu->addChild('Echanges', array('route' => 'echange'));        
        $menu->addChild('Profil', array('route' => 'fos_user_profile_show'));
        $menu->addChild('Déconnexion', array('route' => 'fos_user_security_logout'));
        
//        $menu->addChild('About Me', array(
//            'route' => 'page_show',
//            'routeParameters' => array('id' => 42)
//        ));
        
        return $menu;
    }
    
}
