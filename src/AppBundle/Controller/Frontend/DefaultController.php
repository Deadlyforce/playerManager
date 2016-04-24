<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultController
 * 
 * @Route("/")
 */
class DefaultController extends Controller
{   
    /**
     * @Route("/index", name="home_index")
     * @Template(":Frontend/Default:index.html.twig")
     */
    public function indexAction()
    { 
        return array('msg' => 'Bienvenue sur la page d\'index du Player Manager');
    }
    
    /**
     * @Route("/change_locale", name="change_locale")
     */
    public function changeLocaleAction(Request $request)
    {
        $localeCookie = $this->readCookie($request);

        if ($localeCookie != null) {
            $response = new Response();
            $response->headers->clearCookie('user_locale');
            $response->send();                    
        } 
        
        $routeLocale = $request->getLocale();
        $this->setCookie($routeLocale);

        return $this->redirectToRoute('fos_user_security_login', array("_locale" => $routeLocale));
    }
    
    /**
     * Returns the locale cookie if it exists.     
     */
    public function readCookie($request)
    {      
        $localeCookie = $request->cookies->get('user_locale');

        if ($localeCookie != null) {
            $response = new Response($localeCookie);
        } else {
            $response = null;
        }
  
        return $response;        
    }
    
    public function setCookie($locale)
    {
        $value = $locale;
        $response = new Response();          
        $response->headers->setCookie(new Cookie('user_locale', $value, time() + (3600 * 48))); 
        $response->send();
        
        return $response; 
    }
}
