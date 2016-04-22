<?php

namespace AppBundle\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Description of RedirectionAfterLogin
 *
 * @author Norman
 */
class RedirectionAfterLogin implements AuthenticationSuccessHandlerInterface
{
    private $router;    
    private $defaultLocale;
 
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, $defaultLocale = 'en')
    {
        $this->router = $router;
        $this->defaultLocale = $defaultLocale;
    }
    
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $defaultLocale = $request->getSession()->get('_locale', $this->defaultLocale);

        $locale = $token->getUser()->getLocale();
        
        if ($locale) {
            return new RedirectResponse($this->router->generate('home_index', array('_locale' => $locale)));            
        } else {
            return new RedirectResponse($this->router->generate('home_index', array('_locale' => $defaultLocale)));
        }
        
    }
}
