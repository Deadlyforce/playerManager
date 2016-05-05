<?php

namespace AppBundle\DependencyInjection\Managers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of DefaultManager
 *
 * @author Norman
 */
class DefaultManager 
{   
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;        
    }
    
    /**
     * Sets a cookie
     * 
     * @param string $locale
     */
    public function setCookie($locale)
    {
        $response = new Response();          
        $response->headers->setCookie(new Cookie('user_locale', $locale, time() + (3600 * 72))); 
        $response->send();
    }
}
