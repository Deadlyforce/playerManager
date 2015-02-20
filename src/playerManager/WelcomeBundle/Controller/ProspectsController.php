<?php

namespace playerManager\WelcomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use playerManager\WelcomeBundle\Entity\Prospects;
use playerManager\WelcomeBundle\Form\ProspectsType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// ACL
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Prospects controller.
 *
 * @Route("/prospects")
 */
class ProspectsController extends Controller
{

    /**
     * Lists all Prospects entities.
     *
     * @Route("/", name="prospects")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('playerManagerWelcomeBundle:Prospects')->findAll();
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
       
        foreach($entities as $prospect){            
            if(FALSE === $securityContext->isGranted('VIEW', $prospect)){
                
            }else{                
                $allowedProspects[] = $prospect;
            }        
        }
        
        if(!isset($allowedProspects)){
            $allowedProspects = NULL;
        }
        // End of check
        
        return array(
//            'entities' => $entities,
            'entities' => $allowedProspects,
        );
    }
    
    /**
     * Creates a new Prospects entity.
     *
     * @Route("/", name="prospects_create")
     * @Method("POST")
     * @Template("playerManagerWelcomeBundle:Prospects:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Prospects();
        
        // Récup utilisateur et chargement de son id dans l'entité Prospects
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

            return $this->redirect($this->generateUrl('prospects_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Prospects entity.
     *
     * @param Prospects $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Prospects $entity)
    {
        $form = $this->createForm(new ProspectsType(), $entity, array(
            'action' => $this->generateUrl('prospects_create'),
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
     * Displays a form to create a new Prospects entity.
     *
     * @Route("/new", name="prospects_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $prospect = new Prospects();

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
     * Finds and displays a Prospects entity.
     *
     * @Route("/{id}", name="prospects_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
        }
        
        // Vérification d'accès ACL
        $securityContext = $this->get('security.context');
        
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
     * Displays a form to edit an existing Prospects entity.
     *
     * @Route("/{id}/edit", name="prospects_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
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
    * Creates a form to edit a Prospects entity.
    *
    * @param Prospects $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Prospects $entity)
    {
        $form = $this->createForm(new ProspectsType(), $entity, array(
            'action' => $this->generateUrl('prospects_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Prospects entity.
     *
     * @Route("/{id}", name="prospects_update")
     * @Method("PUT")
     * @Template("playerManagerWelcomeBundle:Prospects:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
//            $entity->upload();
            $em->flush();

//            return $this->redirect($this->generateUrl('prospects_edit', array('id' => $id)));
            return $this->redirect($this->generateUrl('prospects'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Prospects entity.
     *
     * @Route("/{id}", name="prospects_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);       

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prospects entity.');
            }
            
            // Suppression des ACL
            $this->deleteACL($entity);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prospects'));
    }

    /**
     * Creates a form to delete a Prospects entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prospects_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Suppression des ACL associés
     * 
     * @param Prospects $entity
     */
    private function deleteACL(Prospects $entity){        
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $aclProvider->deleteAcl($objectIdentity);            
    }
    
    /**
     * Création d'un ACL
     * 
     * @param Prospects $entity
     */
    private function createACL(Prospects $entity){
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
