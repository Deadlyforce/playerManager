<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Prospect;
use AppBundle\Form\ProspectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\CsrfToken;


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
     * @Route("ajax_form_new", name="ajax_new_prospect_form")
     * @Method({"GET"})
     * @Template("AppBundle:ajax.html.twig")
     */
    public function ajax_newFormNewAction()
    {
        $prospect = new Prospect();
        
        $prospect->setAge(23); // Age par défaut
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris')); // Date du jour
        $prospect->setDateCreation($datetime);
        
        $form = $this->createCreateForm($prospect)->createView();
        $form_view = $this->renderView("AppBundle:Prospect:new.html.twig", array('form' => $form));
                
        return new Response($form_view);
    }
    
    /**
     * Returns a form new prospect
     * 
     * @Route("{id}/ajax_delete", name="ajax_delete_prospect")
     * @Method({"POST"})
     * @Template("AppBundle:ajax.html.twig")
     */
    public function ajax_deleteAction(Request $request, $id)
    {
        $data = $request->request->all();
        $token = $data['csrf_token'];
       
        $csrf = $this->get('security.csrf.token_manager');
           
        if ($csrf->isTokenValid(new CsrfToken('', $token))) {
            
            $em = $this->getDoctrine()->getManager();
            $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

            if (!$prospect) {
                throw $this->createNotFoundException('Unable to find Prospect entity.');
            }            
            
            $this->deleteACL($prospect); // Suppression des ACL
            $this->deleteACL($prospect->getRelation()); // Suppression des ACL
            $this->deleteACL($prospect->getPhoto()); // Suppression des ACL

            $em->remove($prospect);
            $em->flush();
        }
                
        return new Response('Le prospect a bien été supprimé');
    }
    
    
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
        $prospects = $em->getRepository('AppBundle:Prospect')->findAll();
       
        // Vérification d'accès ACL       
        foreach($prospects as $prospect){            
            if(FALSE === $this->get('security.authorization_checker')->isGranted('VIEW', $prospect)){
                
            }else{                
                $allowedProspects[] = $prospect;
            }        
        }
        
        if(!isset($allowedProspects)){
            $allowedProspects = NULL;
        }
        // End of check        
                
        $tokenManager = $this->get('security.csrf.token_manager');        
        $csrf_token = $tokenManager->refreshToken('');
                
        return array(
            'prospects' => $allowedProspects,
            'csrf_token' => $csrf_token
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
        $manager = $this->get('prospect_manager');
        $prospect = new Prospect();       
        
        $form = $this->createCreateForm($prospect);
        $form->handleRequest($request);        
        
        // Récup utilisateur et chargement de son id dans l'entité Photo
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $photo = $prospect->getPhoto();
        $photo->setUserId($user->getId());
        // Récup fin
        
        if ($form->isValid()) {            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($prospect);    

            $photo = $prospect->getPhoto();
        
            // STOF UPLOADABLE
            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
            $uploadableManager->markEntityToUpload($photo, $photo->getFile());
            
            $em->flush();
            
            $manager->createACL($prospect); // Création d'ACL
            $manager->createACL($prospect->getRelation()); // Création d'ACL         
            $manager->createACL($prospect->getphoto()); // Création d'ACL         

            return $this->redirect($this->generateUrl('prospect_show', array('id' => $prospect->getId())));
        }

        return array(
            'prospect' => $prospect,
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
        $form = $this->createForm(ProspectType::class, $entity, array(
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
        if(FALSE === $this->get('security.authorization_checker')->isGranted('VIEW', $prospect)){
            throw new AccessDeniedException();
        }
        // Vérification fin

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'prospect' => $prospect,
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
        if(FALSE === $this->get('security.authorization_checker')->isGranted('EDIT', $entity)){
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
        $form = $this->createForm(ProspectType::class, $entity, array(
            'action' => $this->generateUrl('prospect_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Enregistrer',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

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
        $manager = $this->get('prospect_manager');
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($prospect);
        $editForm->handleRequest($request);

        // Récup utilisateur pour chargement de son id dans l'entité Photo
        $user = $this->get('security.token_storage')->getToken()->getUser();       

        if ($editForm->isValid()) {  
            
            $photo = $prospect->getPhoto();      
            // S'il s'agit d'une photo qui existait déjà, on ne recrée pas d'acl
            $acl = ($photo instanceof \Doctrine\Common\Persistence\Proxy && $photo->__isInitialized()) ? false : true;
               
            // Si aucun choix utilisateur, upload simple sans se soucier de la photo
            if($photo === null){
                $em->flush();
            }else{
                $photo->setUserId($user->getId());
                
                // STOF UPLOADABLE
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                
                $em->flush();
                
                if(!$acl){
                    $manager->createACL($photo);
                }               
            }           
            
            return $this->redirect($this->generateUrl('prospect'));
        }

        return array(
            'prospect'      => $prospect,
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
            $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

            if (!$prospect) {
                throw $this->createNotFoundException('Unable to find Prospect entity.');
            }            
            
            $this->deleteACL($prospect); // Suppression des ACL

            $em->remove($prospect);
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
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr' => array(
                    'class' => 'btn btn-default'
                )
            ))
            ->getForm()
        ;
    }
    
    /**
     * Suppression des ACL associés
     * 
     * @param $entity
     */
    private function deleteACL($entity){        
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $aclProvider->deleteAcl($objectIdentity);            
    }
   
}
