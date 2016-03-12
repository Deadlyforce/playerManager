<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Relation;
use AppBundle\Form\RelationType;

/**
 * Relation controller.
 *
 * @Route("/relation")
 */
class RelationController extends Controller
{

    /**
     * Lists all Relation entities.
     *
     * @Route("/", name="relation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relations = $em->getRepository('AppBundle:Relation')->findByUser($user);

        return array(
            'relations' => $relations,
        );
    }
    
    /**
     * Creates a new Relation entity.
     *
     * @Route("/create", name="relation_create")
     * @Method("POST")
     * @Template("AppBundle:Relation:new.html.twig")
     */
//    public function createAction(Request $request)
//    {
//        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
//            throw $this->createAccessDeniedException('You cannot access this page!');
//        }
//        
//        $relation = new Relation();
//        $form = $this->createCreateForm($relation);
//        $form->handleRequest($request);        
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            
//            $em->persist($relation);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('relation_show', array('id' => $relation->getId())));
//        } else {
//            throw $this->createAccessDeniedException('Oops it seems ther is a problem with your form!');
//        }
//
////        return array(
////            'relation' => $relation,
////            'form'   => $form->createView(),
////        );
//    }

    /**
     * Creates a form to create a Relation entity.
     *
     * @param Relation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
//    private function createCreateForm(Relation $entity)
//    {
//        $form = $this->createForm(new RelationType(), $entity, array(
//            'action' => $this->generateUrl('relation_create'),
//            'method' => 'POST',
//        ));
//
//        $form->add('submit', 'submit', array('label' => 'Create'));
//
//        return $form;
//    }

    /**
     * Displays a form to create a new Relation entity.
     *
     * @Route("/new", name="relation_new")
     * @Method("GET")
     * @Template()
     */
//    public function newAction()
//    {
//        $entity = new Relation();
//        $form   = $this->createCreateForm($entity);
//
//        return array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        );
//    }

    /**
     * Finds and displays a Relation entity.
     *
     * @Route("/{id}/show", name="relation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
                        
        $em = $this->getDoctrine()->getManager();
        $relation = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        } 
        
        if($relation->getProspect()->getUser() === $user){                 

            $deleteForm = $this->createDeleteForm($id);

            return array(
                'relation' => $relation,
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }

    /**
     * Displays a form to edit an existing Relation entity.
     *
     * @Route("/{id}/edit", name="relation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relation = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }        
                   
        if($relation->getProspect()->getUser() === $user){
            $editForm = $this->createEditForm($relation);
            $deleteForm = $this->createDeleteForm($id);

            return array(
                'relation' => $relation,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }

    /**
    * Creates a form to edit a Relation entity.
    *
    * @param Relation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Relation $entity)
    {
        $form = $this->createForm(new RelationType(), $entity, array(
            'action' => $this->generateUrl('relation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Relation entity.
     *
     * @Route("/{id}", name="relation_update")
     * @Method("PUT")
     * @Template("playerManagerWelcomeBundle:Relation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $relation = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$relation) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }

        if($relation->getProspect()->getUser() === $user){
            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($relation);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em->flush();

                return $this->redirect($this->generateUrl('relation'));
            }

            return array(
                'relation' => $relation,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }
    
    /**
     * Deletes a Relation entity.
     *
     * @Route("/{id}", name="relation_delete")
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
            $relation = $em->getRepository('AppBundle:Relation')->find($id);

            if (!$relation) {
                throw $this->createNotFoundException('Unable to find Relation entity.');
            }
            
            if($relation->getProspect()->getUser() === $user){
            
                $em->remove($relation);
                $em->flush();
                
                return $this->redirect($this->generateUrl('relation'));
            } else {
                throw $this->createAccessDeniedException('You cannot access this page!');
            }
        }      
    }

    /**
     * Creates a form to delete a Relation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('relation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
