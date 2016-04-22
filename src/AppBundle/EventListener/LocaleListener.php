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

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        
        if (!$request->hasPreviousSession()) {
            return;
        }        
        
        $locale = $request->attributes->get('_locale');
        // try to see if the locale has been set as a _locale routing parameter
        if ($locale) {
            
            // get preferred locale from the browser
//            $preferredLocale = $request->getPreferredLanguage(array('en', 'fr'));
//
//            if ($preferredLocale) {
//                $request->getSession()->set('_locale', $preferredLocale);
//                $request->setLocale($preferredLocale);
//                $this->router->getContext()->setParameter('_locale', $preferredLocale);                
//            } else {
                $request->getSession()->set('_locale', $locale); // Standard behavior
//            }            
            
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
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
