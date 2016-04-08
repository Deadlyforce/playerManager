<?php
namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;


/**
 * Prospect controller.
 *
 * @Route("/admin/user")
 */
class UserController extends Controller
{   
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     * @Template(":Backend/User:index.html.twig")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        
        $tokenManager = $this->get('security.csrf.token_manager');        
        $csrf_token = $tokenManager->refreshToken('');
                
        return array(
            'users' => $users,
            'csrf_token' => $csrf_token
        );
    }
    
    /**
     * Disable a user
     * 
     * @Route("/{id}/ajax_disable", name="ajax_disable_user", options={"expose"=true})
     * @Method({"POST"})
     */
    public function disableAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $data = $request->request->all();
        $token = $data['csrf_token'];
       
        $csrf = $this->get('security.csrf.token_manager');
        
        if ($csrf->isTokenValid(new CsrfToken('', $token))) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $user->setEnabled(false);
            $em->flush();
            
//            $tokenManager = $this->get('security.csrf.token_manager');        
//            $csrf_token = $tokenManager->refreshToken('');

            $response_array = array(
                "id" => $id,
                "username" => $user->getUsername(),
                "enabled" => $user->isEnabled(),
                "email" => $user->getEmail(),
                "lastLogin" => $user->getLastLogin(),
                "createdAt" => $user->getCreatedAt(),
                "ip" => $user->getIp(),
                'csrf' => $token
            );        

            $response = json_encode($response_array);

            return new Response($response);
        }       
    }
    
    /**
     * Enable a user
     * 
     * @Route("/{id}/ajax_enable", name="ajax_enable_user", options={"expose"=true})
     * @Method({"POST"})
     */
    public function enableAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $data = $request->request->all();
        $token = $data['csrf_token'];
       
        $csrf = $this->get('security.csrf.token_manager');
        
        if ($csrf->isTokenValid(new CsrfToken('', $token))) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $user->setEnabled(true);
            $em->flush();
            
//            $tokenManager = $this->get('security.csrf.token_manager');        
//            $csrf_token = $tokenManager->refreshToken('');

            $response_array = array(
                "id" => $id,
                "username" => $user->getUsername(),
                "enabled" => $user->isEnabled(),
                "email" => $user->getEmail(),
                "lastLogin" => $user->getLastLogin(),
                "createdAt" => $user->getCreatedAt(),
                "ip" => $user->getIp(),
                'csrf' => $token
            );        

            $response = json_encode($response_array);

            return new Response($response);
        }       
    }
    
    /**
     * Returns a form new prospect
     * 
     * @Route("/{id}/ajax_delete", name="ajax_delete_user", options={"expose"=true})
     * @Method({"POST"})
     * @Template(":ajax.html.twig")
     */
    public function ajax_deleteAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $data = $request->request->all();
        $token = $data['csrf_token'];
       
        $csrf = $this->get('security.csrf.token_manager');
           
        if ($csrf->isTokenValid(new CsrfToken('', $token))) {
            
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->find($id);

            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }           
            
            $em->remove($user);
            $em->flush(); 
            
            $response_array = array("id" => $id);        
            $response = json_encode($response_array);

            return new Response($response);
        }       
    }
    
}
