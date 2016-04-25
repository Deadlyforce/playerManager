<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Form\ContactUsType;

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
     * @Route("/contact_us", name="contact_us")
     * @param Request $request 
     * @Template(":Frontend/Default:contact_us.html.twig")
     */
    public function contactUsAction(Request $request)
    {
        $form = $this->createForm(ContactUsType::class);        
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('webmaster@playermanager.com')
                    ->setBody(
                        $this->renderView(':Frontend/Mail:mail_message.html.twig', array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'subject' => $form->get('subject')->getData(),
                                'message' => $form->get('message')->getData(),
                                'email' => $form->get('email')->getData()
                            )
                        ), 'text/html'
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

                return $this->redirect($this->generateUrl('contact_us'));
            }
        }
        
        return array(
            'form' => $form->createView()
        );
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
