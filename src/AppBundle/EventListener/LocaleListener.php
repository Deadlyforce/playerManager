<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocale;
    private $router;
    
    public function __construct(UrlGeneratorInterface $router, $defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
        $this->router = $router;
    }
    
    /**
     * Returns the locale cookie if it exists.     
     */
    public function readCookie($request)
    {      
        $localeCookie = $request->cookies->get('user_locale');        
  
        return $localeCookie;        
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        
        if (!$request->hasPreviousSession()) {
            return;
        }        
        
        $locale = $request->attributes->get('_locale');
        $localeBrowser = $request->getPreferredLanguage(array('en', 'fr')); // get preferred locale from the browser
        
        // try to see if the locale has been set as a _locale routing parameter
        // initial path is "/" without locale prefix, which redirects to home_index in routing.yml (with locale prefixed) 
        // then redirects to "fos_user_security_login" (with locale prefixed) if user not authenticated        
        if ($locale) {
            // Locale found in URL
            $request->getSession()->set('_locale', $locale); // Standard behavior           
        } else {
            // Root path actions "/"
            // No locale detected in URL, reads cookie
            $localeCookie = $this->readCookie($request);
            
            // If cookie exists
            if ($localeCookie !== null) {
                // Set cookie locale
                $request->getSession()->set('_locale', $localeCookie);
                $this->router->getContext()->setParameter('_locale', $localeCookie);
            } else {
                // No cookie exists
                // Get locale from browser preferences and use it
                if ($localeBrowser) {
                    $request->getSession()->set('_locale', $localeBrowser);
                    $this->router->getContext()->setParameter('_locale', $localeBrowser); 
                } else {
                    // if no explicit locale has been set on this request, use one from the session
                    $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
                }
            }                       
        }        
    }

    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }   
}
