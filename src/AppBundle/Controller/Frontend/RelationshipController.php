<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\RelationshipType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Relationship controller.
 *
 * @Route("/relationship")
 */
class RelationshipController extends Controller
{
    /**
     * Returns a form edit relationship
     * 
     * @Route("/{id}/ajax_form_edit", name="ajax_edit_relationship_form", options={"expose"=true})
     * @Method({"GET"})
     * @Template(":ajax.html.twig")
     */
    public function ajax_FormEditAction($id)
    {              
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();               
        $relationship = $em->find("AppBundle:Relationship", $id);
        
        if ($user === $relationship->getProspect()->getUser()) {        

            $edit_form = $this->createForm('AppBundle\Form\RelationshipType', $relationship, array( 
                'action' => $this->generateUrl('relationship_edit', array('id' => $id)),
                'method' => 'PUT'
            ));
            $delete_form = $this->createDeleteForm($id);
            
            $editForm_view = $this->renderView(":Frontend/Relationship:ajaxEdit.html.twig", array(
                'edit_form' => $edit_form->createView(),
                'delete_form' => $delete_form->createView(),
                'relationship' => $relationship
            ));

            return new Response($editForm_view);
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Lists all Relationship entities.
     *
     * @Route("/", name="relationship")
     * @Method("GET")
     * @Template(":Frontend/Relationship:index.html.twig")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relationships = $em->getRepository('AppBundle:Relationship')->findByUser($user);

        return array(
            'relationships' => $relationships,
        );
    }   

    /**
     * Displays a form to edit an existing Relationship entity.
     *
     * @Route("/{id}/edit", name="relationship_edit")
     * @Method({"GET","PUT"})
     * @Template(":Frontend/Relationship:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relationship = $em->getRepository('AppBundle:Relationship')->find($id);

        if (!$relationship) {
            throw $this->createNotFoundException('Unable to find Relationship entity.');
        }        
                   
        if($relationship->getProspect()->getUser() === $user){
            $editForm = $this->createForm(RelationshipType::class, $relationship, array(                
                'method' => 'PUT'
            ));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('prospect_show', array('id' => $relationship->getProspect()->getId())));
            }            
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }
    
    /**
     * Edits an existing Relationship entity.
     *
     * @Route("/{id}", name="relationship_update")
     * @Method("PUT")
     * @Template(":Frontend/Relationship:edit.html.twig")
     */
//    public function updateAction(Request $request, $id)
//    {
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            throw $this->createAccessDeniedException('You cannot access this page!');
//        }
//        
//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        
//        $em = $this->getDoctrine()->getManager();
//        $relationship = $em->getRepository('AppBundle:Relationship')->find($id);
//
//        if (!$relationship) {
//            throw $this->createNotFoundException('Unable to find Relationship entity.');
//        }
//
//        if($relationship->getProspect()->getUser() === $user){
//            $deleteForm = $this->createDeleteForm($id);
//            $editForm = $this->createForm(RelationshipType::class, $relationship, array(
//                'action' => $this->generateUrl('relationship_update', array('id' => $relationship->getId())),
//                'method' => 'PUT'
//            ));
//            $editForm->handleRequest($request);
//
//            if ($editForm->isSubmitted() && $editForm->isValid()) {
//                $em->flush();
//
//                return $this->redirect($this->generateUrl('relationship_edit', array('id' => $id)));
//            }
//
//            return array(
//                'relationship' => $relationship,
//                'edit_form' => $editForm->createView(),
//                'delete_form' => $deleteForm->createView(),
//            );
//        } else {
//            throw $this->createAccessDeniedException('You cannot access this page!');
//        }       
//    }
    
    /**
     * Updates an existing Relationship entity using ajax.
     *
     * @Route("/{id}/ajax_update", name="ajax_relationship_update", options={"expose"=true})
     * @Method("PUT")
     * @Template(":ajax.html.twig")
     */
    public function ajaxUpdateAction(Request $request, $id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relationship = $em->getRepository('AppBundle:Relationship')->find($id);

        if($relationship->getProspect()->getUser() === $user){

            $editForm = $this->createForm(RelationshipType::class, $relationship, array(
                'method' => 'PUT'
            ));
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em->flush();
                
                return new Response('success');
            } else {
                return new Response('failure');
            }

        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }
    
    /**
     * Deletes a Relationship entity.
     *
     * @Route("/{id}", name="relationship_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $relationship = $em->getRepository('AppBundle:Relationship')->find($id);

            if (!$relationship) {
                throw $this->createNotFoundException('Unable to find Relationship entity.');
            }
            
            if($relationship->getProspect()->getUser() === $user){
            
                $em->remove($relationship);
                $em->flush();
                
                return $this->redirect($this->generateUrl('relationship'));
            } else {
                throw $this->createAccessDeniedException('You cannot access this page!');
            }
        }      
    }

    /**
     * Creates a form to delete a Relationship entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('relationship_delete', array('id' => $id)))
            ->setMethod('DELETE')
//            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
