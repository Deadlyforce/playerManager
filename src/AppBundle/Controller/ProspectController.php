<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Prospect;
use AppBundle\Form\ProspectType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// ACL
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Prospect controller.
 *
 * @Route("/prospect")
 */
class ProspectController extends Controller
{

    /**
     * Lists all Prospect entities.
     *
     * @Route("/", name="prospect")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Prospect')->findAll();
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
       
        foreach($entities as $prospect){            
            if(FALSE === $securityContext->isGranted('VIEW', $prospect)){
                
            }else{                
                $allowedProspect[] = $prospect;
            }        
        }
        
        if(!isset($allowedProspect)){
            $allowedProspect = NULL;
        }
        // End of check
        
        return array(
//            'entities' => $entities,
            'entities' => $allowedProspect,
        );
    }
    
    /**
     * Creates a new Prospect entity.
     *
     * @Route("/", name="prospect_create")
     * @Method("POST")
     * @Template("AppBundle:Prospect:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Prospect();
        
        // Récup utilisateur et chargement de son id dans l'entité Prospect
        $user = $this->get('security.context')->getToken()->getUser();
        $entity->setUserId($user->getId());
        // Récup fin
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {            
            // Création d'ACL
            $this->createACL($entity);
            
//            $entity->upload();
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prospect_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Prospect entity.
     *
     * @param Prospect $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Prospect $entity)
    {
        $form = $this->createForm(new ProspectType(), $entity, array(
            'action' => $this->generateUrl('prospect_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Créer ce contact',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Prospect entity.
     *
     * @Route("/new", name="prospect_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $prospect = new Prospect();

        // Définition des paramètres par défaut
        $prospect->setAge(23);
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $prospect->setDateCreation($datetime);

        $form = $this->createCreateForm($prospect);        
        
        return array(
            'entity' => $prospect,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prospect entity.
     *
     * @Route("/{id}", name="prospect_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
        
        if(FALSE === $securityContext->isGranted('VIEW', $prospect)){
            throw new AccessDeniedException();
        }
        // Vérification fin

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'prospect'      => $prospect,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prospect entity.
     *
     * @Route("/{id}/edit", name="prospect_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
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
    * Creates a form to edit a Prospect entity.
    *
    * @param Prospect $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Prospect $entity)
    {
        $form = $this->createForm(new ProspectType(), $entity, array(
            'action' => $this->generateUrl('prospect_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Prospect entity.
     *
     * @Route("/{id}", name="prospect_update")
     * @Method("PUT")
     * @Template("AppBundle:Prospect:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
//            $entity->upload();
            $em->flush();

//            return $this->redirect($this->generateUrl('prospect_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('prospect'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Prospect entity.
     *
     * @Route("/{id}", name="prospect_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);       

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Prospect')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prospect entity.');
            }
            
            // Suppression des ACL
            $this->deleteACL($entity);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prospect'));
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Suppression des ACL associés
     * 
     * @param Prospect $entity
     */
    private function deleteACL(Prospect $entity){        
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $aclProvider->deleteAcl($objectIdentity);            
    }
    
    /**
     * Création d'un ACL
     * 
     * @param Prospect $entity
     */
    private function createACL(Prospect $entity){
        $entityManager = $this->get('doctrine.orm.default_entity_manager');
        $entityManager->persist($entity);
        $entityManager->flush();

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
}
