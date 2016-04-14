<?php
namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Prospect;
use AppBundle\Form\ProspectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Doctrine\Common\Collections\ArrayCollection; 

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
    public function ajax_newFormNewAction()
    {       
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $prospect = new Prospect();
        
        $prospect->setAge(23); // Age par défaut
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris')); // Date du jour
        $prospect->setCreationDate($datetime);
        
        $form = $this->createCreateForm($prospect)->createView();
        $form_view = $this->renderView(":Frontend/Prospect:new.html.twig", array('form' => $form));
                
        return new Response($form_view);
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $data = $request->request->all();
        $token = $data['csrf_token'];
       
        $csrf = $this->get('security.csrf.token_manager');
           
        if ($csrf->isTokenValid(new CsrfToken('', $token))) {
            
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
        
        $response_array = array("id" => $id);        
        $response = json_encode($response_array);
        
        return new Response($response);
    }    
    
    /**
     * Lists all Prospect entities.
     *
     * @Route("/", name="prospect")
     * @Method("GET")
     * @Template(":Frontend/Prospect:index.html.twig")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospects = $em->getRepository('AppBundle:Prospect')->findBy(
            array("user" => $user), 
            array("creationDate" => "DESC")
        );
                
        $tokenManager = $this->get('security.csrf.token_manager');        
        $csrf_token = $tokenManager->refreshToken('');
                
        return array(
            'prospects' => $prospects,
            'csrf_token' => $csrf_token
        );
    }
    
    /**
     * Lists Prospect entities.
     *
     * @Route("/list", name="prospect_list")
     * @Method("GET")
     * @Template(":Frontend/Prospect:list.html.twig")
     */
    public function listAction($page = 0)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
//        $prospects = $em->getRepository('AppBundle:Prospect')->findBy(
//            array("user" => $user), 
//            array("creationDate" => "DESC")
//        );
        $paginate = 5;
        $prospects = $em->getRepository('AppBundle:Prospect')->getProspects($user, $page, $paginate);            
 
        $totalPages = ceil(count($prospects)/$paginate);
        
        
        $tokenManager = $this->get('security.csrf.token_manager');        
        $csrf_token = $tokenManager->refreshToken('');
                
        return array(
            'prospects' => $prospects,
            'csrf_token' => $csrf_token,
            'totalPages' => $totalPages
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }        
        
        $prospect = new Prospect();       
        
        $form = $this->createCreateForm($prospect);
        $form->handleRequest($request);        
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $photos = $prospect->getPhotos();
        
        $prospect->setUser($user);        
       
        if ($form->isSubmitted() && $form->isValid()) {            
            
            $em = $this->getDoctrine()->getManager();
            
            $prospect->getRelationship()->setMeetingCount(0); // Needed, not nullable
            
            $em->persist($prospect);  
       
            // Removed at prospect creation => done in gallery
            // STOF UPLOADABLE 
//            $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
//
//            foreach($photos as $photo){
//                $uploadableManager->markEntityToUpload($photo, $photo->getFile());
//            }           
           
            $em->flush();                  
            
            return $this->redirectToRoute('prospect');
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

        return $form;
    }

    /**
     * Displays a form to create a new Prospect entity.
     *
     * @Route("/new", name="prospect_new")
     * @Method("GET")
     * @Template(":Frontend/Prospect:new.html.twig")
     */
    public function newAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $prospect = new Prospect();

        // Définition des paramètres par défaut
        $prospect->setAge(23);
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $prospect->setCreationDate($datetime);

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
     * @Template(":Frontend/Prospect:show.html.twig")
     */
    public function showAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
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
     * Displays a form to edit an existing Prospect entity.
     *
     * @Route("/{id}/edit", name="prospect_edit")
     * @Method("GET")
     * @Template(":Frontend/Prospect:edit.html.twig")
     */
    public function editAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        } 
        
        if($prospect->getUser() === $user){
            $editForm = $this->createEditForm($prospect);
            $deleteForm = $this->createDeleteForm($id);

            return array(
                'prospect' => $prospect,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
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

        return $form;
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }

        if($prospect->getUser() === $user){
            
            $originalPhotos = new ArrayCollection();

            // Create an ArrayCollection of the current Photo objects in the database
            foreach ($prospect->getPhotos() as $photo) {
                $originalPhotos->add($photo);              
            }
        
            $deleteForm = $this->createDeleteForm($id);
            $editForm = $this->createEditForm($prospect);
            $editForm->handleRequest($request);
         
            if ($editForm->isSubmitted() && $editForm->isValid()) {  
         
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $photos = $prospect->getPhotos();                               

                if ($originalPhotos->isEmpty()) {
                    // Case: update a Prospect without a previous photo
                    foreach ($photos as $photo) {
                        $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                    }      
                    
                    $em->flush();
                } else {
                    // Case: update a Prospect with a previous photo, with and without changes
                    // remove the relationship between the photo and the Prospect
                    foreach ($originalPhotos as $originalPhoto) {

                        if ($photos->contains($originalPhoto) === false) {
                            // Remove deleted photos
                            $prospect->removePhoto($originalPhoto);
                            
                            // if many-to-one relationship, remove also the relationship
                            $originalPhoto->setProspect(null);                            
                            $em->remove($originalPhoto); // Delete the Photo entirely

                            // Upload new photos
                            foreach ($photos as $photo) {
                                // if $photo->getFile() is null, it means the file hasn't changed. No need to re-upload. Else re-validate upload.
                                if ($photo->getFile()) {                                
                                    $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                                }
                            }
                        } else {
                            foreach ($photos as $photo) {
                                // if $photo->getFile() is null, it means the file hasn't changed. No need to re-upload. Else re-validate upload.
                                if ($photo->getFile()) {                                
                                    $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                                }
                            }
                        }
                    }

                    $em->persist($prospect);
                    $em->flush();
                }              

                return $this->redirectToRoute('gallery', array('prospect_id' => $id));
            }

            return array(
                'prospect' => $prospect,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView()
            );
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
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
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
            ->getForm()
        ;
    } 
    
}
