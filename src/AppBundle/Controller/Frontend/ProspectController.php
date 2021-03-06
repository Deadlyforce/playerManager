<?php
namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Prospect;
use AppBundle\Entity\Option;
use AppBundle\Form\OptionType;
use AppBundle\Form\ProspectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


/**
 * Prospect controller.
 *
 * @Route("/prospect")
 */
class ProspectController extends Controller
{
    /**
     * Returns a form new prospect
     * 
     * @Route("/ajax_form_new", name="ajax_new_prospect_form", options={"expose"=true})
     * @Method({"GET"})
     * @Template(":ajax.html.twig")
     */
    public function ajax_FormNewAction()
    {       
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $prospect = new Prospect();
        
        $prospect->setAge(23); // Age par défaut
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris')); // Date du jour
        $prospect->setCreationDate($datetime);        

        $form = $this->createForm(ProspectType::class, $prospect, array(
            'action' => $this->generateUrl('prospect_create'),
            'method' => 'POST'
        ));
        $form_view = $this->renderView(":Frontend/Prospect:new.html.twig", array('form' => $form->createView()));
                
        return new Response($form_view);
    }
    
    /**
     * Returns a form edit prospect.
     * 
     * @Route("/{id}/ajax_form_edit", name="ajax_edit_prospect_form", options={"expose"=true})
     * @Method({"GET"})
     * @Template(":ajax.html.twig")
     */
    public function ajax_FormEditAction($id)
    {       
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();               
        $prospect = $em->find("AppBundle:Prospect", $id);
        
        if ($user === $prospect->getUser()) {        

            $editForm = $this->createForm(ProspectType::class, $prospect, array(
                'action' => $this->generateUrl('prospect_update', array('id' => $id)),
                'method' => 'PUT'
            ));
            
            $editForm_view = $this->renderView(":Frontend/Prospect:edit.html.twig", array(
                'editForm' => $editForm->createView()  
            ));

            return new Response($editForm_view);
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Returns a form new prospect
     * 
     * @Route("/{id}/ajax_delete", name="ajax_delete_prospect", options={"expose"=true})
     * @Method({"POST"})
     * @Template(":ajax.html.twig")
     */
    public function ajax_deleteAction(Request $request, $id)
    {       
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $data = $request->request->all();
        $token = $data['csrfDelete'];
        
        $csrf = $this->get('security.csrf.token_manager');
           
        if ($csrf->isTokenValid(new CsrfToken('delete', $token))) {
            
            $em = $this->getDoctrine()->getManager();
            $prospect = $em->getRepository('AppBundle:Prospect')->find($id);  
            
            if($prospect->getUser() === $user){
                $em->remove($prospect);                
                $em->flush();
                
                $response = json_encode(array(
                    'id' => $id,
                    'success' => $prospect->getFirstName().' '.$prospect->getLastname().' has been deleted !'
                ));

                return new Response($response);

            } else {
                throw $this->createAccessDeniedException('You cannot access this page!');
            }
        } else {
            throw $this->createAccessDeniedException('CSRF token is invalid.');
        }      
    }    
    
    /**
     * Lists Prospect entities.
     *
     * @Route("/list", name="prospect_list", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Template(":Frontend/Prospect:list.html.twig")
     */
    public function listAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();      
        $em = $this->getDoctrine()->getManager();        
                
        $option = $user->getOption();        
        
        $query = $em->getRepository('AppBundle:Prospect')->getProspectsQuery($option->getOrderby(), $user, 1, $option->getSex(), $option->getRelationshipLevel());
        
        $optionForm = $this->createForm(OptionType::class, $option, array(
            'action' => $this->generateUrl('prospect_list'),
            'method' => 'POST'
        ));
        
        $optionForm->handleRequest($request);
        
        if ($optionForm->isSubmitted() && $optionForm->isValid()) {  

            $user->setOption($option);
            
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('prospect_list');
        }
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            8 /*limit per page*/
        );
                       
        return array(
            'pagination' => $pagination,
            'filterForm' => $optionForm->createView()
        );
    }
    
    /**
     * Lists Prospect entities.
     *
     * @Route("/offlist", name="prospect_off", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Template(":Frontend/Prospect:offlist.html.twig")
     */
    public function offlistAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();       
        $em = $this->getDoctrine()->getManager();
                     
        $options = $request->request->get('appbundle_user_options');        
        $query = $em->getRepository('AppBundle:Prospect')->getProspectsQuery($options['orderby'], $user, 0, $options['sex'], $options['relationshipLevel']); 
        
        $option = new Option();
        $optionForm = $this->createForm(OptionType::class, $option, array(
            'action' => $this->generateUrl('prospect_off'),
            'method' => 'POST'
        ));
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            8 /*limit per page*/
        );
                       
        return array(
            'pagination' => $pagination,
            'filterForm' => $optionForm->createView()
        );
    }
    
    /**
     * Creates a new Prospect entity.
     *
     * @Route("/", name="prospect_create")
     * @Method("POST")
     * @Template(":Frontend/Prospect:new.html.twig")
     */
    public function createAction(Request $request)
    {        
        $prospect = new Prospect();        

        $form = $this->createForm(ProspectType::class, $prospect, array(
            'action' => $this->generateUrl('prospect_create'),
            'method' => 'POST'
        ));
        
        $form->handleRequest($request);        
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $prospect->setUser($user);        
       
        if ($form->isSubmitted() && $form->isValid()) {            
            $form->getData();
            $em = $this->getDoctrine()->getManager();
            
            // Depending on entered infos, pre-fill some fields in relationship entity
            if ($prospect->getHomeNumber() !== null || $prospect->getCellNumber() !== null) {
                $prospect->getRelationship()->setNumclosed(true);
            }
            
            if ($prospect->getSource()->getId() === 2) {
                $prospect->getRelationship()->setMeeting(true); // Needed, not nullable                
            }
                   
            $prospect->getRelationship()->setStartDate(new \DateTime());  // Needed, not nullable
            $prospect->getRelationship()->setStatus(true); // Relationship "On" by default
            
            $em->persist($prospect);         
            $em->flush();                  
            
            return $this->redirectToRoute('prospect_list');
        }

        return array(
            'prospect' => $prospect,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prospect entity.
     *
     * @Route("/{id}", name="prospect_show")
     * @Method("GET")
     * @Template(":Frontend/Prospect:show.html.twig")
     */
    public function showAction($id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();
                       
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        } 
        
        if($prospect->getUser() === $user){
            $deleteForm = $this->createDeleteForm($id);

            return array(
                'prospect' => $prospect,
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }
   
    /**
     * Edits an existing Prospect entity.
     *
     * @Route("/{id}", name="prospect_update")
     * @Method("PUT")
     * @Template(":Frontend/Prospect:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }

        if($prospect->getUser() === $user){       
            
            $editForm = $this->createForm(ProspectType::class, $prospect, array(
                'action' => $this->generateUrl('prospect_update', array('id' => $id)),
                'method' => 'PUT'
            ));
            $editForm->handleRequest($request);
         
            if ($editForm->isSubmitted() && $editForm->isValid()) {                      
                    
                $em->persist($prospect);               
                $em->flush();               
                
                return $this->redirectToRoute('prospect_show', array('id' => $id));
            }
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Deletes a Prospect entity.
     *
     * @Route("/{id}", name="prospect_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();       
        
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);       

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

            if (!$prospect) {
                throw $this->createNotFoundException('Unable to find Prospect entity.');
            }        

            if($prospect->getUser() === $user){
                $em->remove($prospect);
                $em->flush();
            } else {
                throw $this->createAccessDeniedException('You cannot access this page!');
            }
        }

        return $this->redirectToRoute('prospect_list');        
    }

    /**
     * Creates a form to delete a Prospect entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prospect_delete', array('id' => $id)))
            ->setMethod('DELETE') 
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'submit'
                ),
            ))
            ->getForm()
        ;
    } 
    
    /**
     * Returns dashboard page with various statistics.
     * 
     * @Route("/dashboard/{user_id}", name="dashboard")
     * @Template(":Frontend/Prospect:dashboard.html.twig")
     */
    public function dashboardAction($user_id)
    {        
        $loggedUser = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $user = $em->find('AppBundle:User', $user_id);
        
        $manager = $this->get('prospect_manager');
        
        if ($loggedUser === $user) {
            // FLAKES 
            $flakesOn = $em->getRepository('AppBundle:Prospect')->getUserFlakesOn($user);   
            $flakesOff = $em->getRepository('AppBundle:Prospect')->getUserFlakesOff($user);   
            $flakeStats = "$flakesOn, $flakesOff";
                        
            // SOURCES         
            $sourcesOnline = $em->getRepository('AppBundle:Prospect')->getUserSourcesOnline($user);   
            $sourcesIRL = $em->getRepository('AppBundle:Prospect')->getUserSourcesIRL($user);   
            $sourceStats = "$sourcesOnline, $sourcesIRL";
            
            // RELATIONSHIP TYPES
            $chatting = $em->getRepository('AppBundle:Prospect')->getUserTotalChatting($user);
            $ons = $em->getRepository('AppBundle:Prospect')->getUserTotalONS($user);
            $ff = $em->getRepository('AppBundle:Prospect')->getUserTotalFuckFriend($user);
            $dating = $em->getRepository('AppBundle:Prospect')->getUserTotalDating($user);
            $open = $em->getRepository('AppBundle:Prospect')->getUserTotalOpenRelationship($user);
            $monogamous = $em->getRepository('AppBundle:Prospect')->getUserTotalMonogamousRelationship($user);
            $relationshipTypes = "$chatting, $ons, $ff, $dating, $open, $monogamous";

            return array(
                'flakeStats' => $flakeStats,
                'sourceStats' => $sourceStats,
                'relationshipTypes' => $relationshipTypes
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    

}
