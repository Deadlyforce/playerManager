<?php

namespace AppBundle\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of RedirectionAfterLogin
 *
 * @author Norman
 */
class RedirectionAfterLogin implements AuthenticationSuccessHandlerInterface
{
    private $router;   
    private $em;   
 
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, EntityManagerInterface $em)
    {
        $this->router = $router; 
        $this->em = $em; 
    }    
    
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $locale = $request->getLocale();
        $user = $token->getUser();
        
        // Count prospects then redirect accordingly
        $prospectsCount = $this->em->getRepository('AppBundle:Prospect')->getProspectsCount($user);        

        if (intval($prospectsCount) === 0) {
            return new RedirectResponse($this->router->generate('home_index', array('_locale' => $locale)));            
        } else {
            return new RedirectResponse($this->router->generate('prospect_list', array('_locale' => $locale)));
        }
        
    }
}
