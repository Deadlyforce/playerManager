<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();          
        
        // Check the presence of previous prospects
        $results = $em->getRepository("AppBundle:Prospect")->getProspectIds($user);
        
        if (count($results) === 0) {
            $noProspect = true;
        } else {
            $noProspect = false;
        }
        
        return array('noProspect' => $noProspect);
    }
    
    /**
     * @Route("/change_locale", name="change_locale")
     */
    public function changeLocaleAction(Request $request)
    {
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
                    ->setTo('contact@playermanager.normanwebdev.com')
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
