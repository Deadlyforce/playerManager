<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Relation;
use AppBundle\Form\RelationType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// ACL
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Relation')->findAll();

        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
        
        // Check for VIEW access
        foreach($entities as $relation){            
            if(FALSE === $securityContext->isGranted('VIEW', $relation)){
                // Do nothing
            }else{                
                $allowedEntities[] = $relation;
            }
        }
       
        if(!isset($allowedEntities)){
            $allowedEntities = NULL;
        }
        // Vérification fin

        return array(
//            'entities' => $entities,
            'entities' => $allowedEntities,
        );
    }
    
    /**
     * Creates a new Relation entity.
     *
     * @Route("/", name="relation_create")
     * @Method("POST")
     * @Template("playerManagerWelcomeBundle:Relation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Relation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        // Implémentation des ACL
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            // Création de l'ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);
            
            // retrouve l'identifiant de sécurité de l'utilisateur actuellement connecté
            $securityContext = $this->get('security.context');
            $user = $securityContext->getToken()->getUser();
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            
            // Donne accès au propriétaire
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
          
            $aclProvider->updateAcl($acl);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('relation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Relation entity.
     *
     * @param Relation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Relation $entity)
    {
        $form = $this->createForm(new RelationType(), $entity, array(
            'action' => $this->generateUrl('relation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Relation entity.
     *
     * @Route("/new", name="relation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Relation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Relation entity.
     *
     * @Route("/{id}", name="relation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
//var_dump($securityContext);
//die();
        if(FALSE === $securityContext->isGranted('VIEW', $entity)){
            throw new AccessDeniedException();
        }
        // Vérification fin

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
        
        if(FALSE === $securityContext->isGranted('EDIT', $entity)){
            throw new AccessDeniedException();
        }
        // Vérification fin
                        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Relation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

//            return $this->redirect($this->generateUrl('relation_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('relation'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Relation entity.
     *
     * @Route("/{id}", name="relation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Relation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Relation entity.');
            }
            
            // ACL suppression
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $aclProvider->deleteAcl($objectIdentity);
            // ACL Suppression fin

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('relation'));
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
