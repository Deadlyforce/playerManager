<?php

namespace AppBundle\EventSubscriber;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Redirects the user on "home_index" if trying to register while already authenticated
 *
 * @author Norman
 */
class FOSUserSubscriber implements EventSubscriberInterface
{
    protected $router;
    protected $authorizationChecker;
    
    public function __construct(UrlGeneratorInterface $router, AuthorizationCheckerInterface $authorizationChecker) 
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE  => 'forwardToRouteIfUser'            
        );
    }
    
    public function forwardToRouteIfUser(GetResponseUserEvent $event)
    {
        if (!$this->$authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }

        $url = $this->router->generate('home_index');       

        $event->setResponse(new RedirectResponse($url));
    }
}
