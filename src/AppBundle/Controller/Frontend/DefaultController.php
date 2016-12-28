<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactUsType;
use AppBundle\Entity\ContactUs;

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
        
        $manager = $this->get('default_manager');
        $manager->setCookie($routeLocale);

        return $this->redirectToRoute('fos_user_security_login', array("_locale" => $routeLocale));
    }
    
    /**
     * @Route("/contact_us", name="contact_us")
     * @param Request $request 
     * @Template(":Frontend/Default:contact_us.html.twig")
     */
    public function contactUsAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $contactUs = new ContactUs;
        $contactUs->setEmail($user->getEmail());
        $form = $this->createForm(ContactUsType::class, $contactUs);        
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('contact@mnaomai.com')
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
                $msg_success = $this->get('translator')->trans('app.contactus.flash.success');
                $request->getSession()->getFlashBag()->add('success_mail', $msg_success);

                return $this->redirect($this->generateUrl('contact_us'));
            }
        }
        
        return array(
            'form' => $form->createView()
        );
    }
    
    
}
