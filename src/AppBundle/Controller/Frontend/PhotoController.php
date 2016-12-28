<?php
namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection; 

use AppBundle\Form\PhotoType;
use AppBundle\Form\ProspectType;


/**
 * PhotoController
 *
 * @author Norman
 * @Route("/photo")
 */
class PhotoController extends Controller
{
    
    /**
     * Gallery index for a given prospect
     * 
     * @Route("/gallery/{prospect_id}", name="gallery")
     * @param int $prospect_id
     * @Template(":Frontend/Photo:gallery.html.twig")
     */
    public function galleryAction($prospect_id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository("AppBundle:Prospect")->find($prospect_id);
        
        if($prospect->getUser() === $user){        
            $photos = $em->getRepository("AppBundle:Photo")->findBy(array("prospect" => $prospect));
            
            $editForm = $this->createForm(ProspectType::class, $prospect, array(
                'action' => $this->generateUrl('prospect_photos_update', array('id' => $prospect->getId())),
                'method' => 'PUT',
            ));            

            return array(
                'photos' => $photos,
                'prospect' => $prospect,
                'editForm' => $editForm->createView()
            );        
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Updates photos in an existing Prospect entity.
     *
     * @Route("/{id}/photos_update", name="prospect_photos_update")
     * @Method("PUT")
     * @Template(":Frontend/Prospect:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository('AppBundle:Prospect')->find($id);
        $manager = $this->get('photo_manager');

        if (!$prospect) {
            throw $this->createNotFoundException('Unable to find Prospect entity.');
        }

        if($prospect->getUser() === $user){
            
            $originalPhotos = new ArrayCollection();

            // Create an ArrayCollection of the current Photo objects existing in the database
            foreach ($prospect->getPhotos() as $photo) {
                $originalPhotos->add($photo);              
            }
            
            $editForm = $this->createForm(ProspectType::class, $prospect, array(
                'action' => $this->generateUrl('prospect_update', array('id' => $id)),
                'method' => 'PUT'
            ));

            $editForm->handleRequest($request);
         
            if ($editForm->isSubmitted() && $editForm->isValid()) {  
         
                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
                $photos = $prospect->getPhotos();  

                if ($originalPhotos->isEmpty()) {
                    $missingFiles = $manager->updateEmptyGallery($photos, $uploadableManager);
                    
                    if (in_array(false, $missingFiles)) {
                        return $this->redirectToRoute('gallery', array('prospect_id' => $id));
                    }    
                    
                    $em->flush();
                } else {  
                    // Case: update a Prospect with a previous photo, with and without changes
                    // remove the relationship between the photo and the Prospect
                    foreach ($originalPhotos as $originalPhoto) {

                        if ($photos->contains($originalPhoto) === false) {

                            // Remove deleted photos
                            $prospect->removePhoto($originalPhoto);                                
                            $originalPhoto->setProspect(null); // remove also the relationship
                            $em->remove($originalPhoto); // Delete the Photo entirely (Doctrine)

                            // Upload new photos
                            foreach ($photos as $photo) {
                                // if $photo->getFile() is null, the file hasn't changed. No need to re-upload. Else re-validate upload.
                                if ($photo->getFile()) { 
                                    $uploadableManager->markEntityToUpload($photo, $photo->getFile());
                                }
                            }
                        } else {
                            foreach ($photos as $photo) {
                                // if $photo->getFile() is null, the file hasn't changed. No need to re-upload. Else re-validate upload.
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
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Crop photo 
     *  
     * @Route("/{id}/edit", name="photo_edit")
     * @Template(":Frontend\Photo:edit.html.twig")
     */
    public function editAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $photo = $em->getRepository('AppBundle:Photo')->find($id);
        
        if($photo->getProspect()->getUser() === $user){        
            $form = $this->createForm(PhotoType::class, $photo);

            return array(
                'photo' => $photo,
                'form' => $form->createView()
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * (Ajax) Crop a photo 
     * 
     * @Method({"POST"})
     * @Route("/{id}/photo_crop", name="photo_crop")
     */
    public function cropAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $photo = $em->find("AppBundle:Photo", $id);

        if($photo->getProspect()->getUser() === $user){        
            $x = $request->request->get('x');
            $y = $request->request->get('y');
            $width = $request->request->get('w');
            $height = $request->request->get('h');

            $targ_w = $targ_h = 512;
            $jpeg_quality = 90;
            
            $src = $photo->getPath();

            $type = $photo->getType();

            if ($type == 'image/jpg' || $type == 'image/jpeg') {
                $img_r = imagecreatefromjpeg($src);
            }
            if ($type == 'image/png') {
                $img_r = imagecreatefrompng($src);
            }
               
            
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );           
            
            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $width, $height);
            
            imagedestroy($img_r);
            // Write image ($dst_r) to destination path        
            imagejpeg($dst_r, $photo->getPath(), $jpeg_quality);

            // Update Photo entity filesize
            $filesize = filesize($photo->getPath());        
            $photo->setSize($filesize);

            $em->flush();                        

            return $this->redirectToRoute('gallery', array('prospect_id' => $photo->getProspect()->getId()));
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    
    /**
     * Displays all prospect primary pictures (or last uploaded)
     * 
     * @Route("/album/{user_id}", name="photo_album")
     * @param int $user_id
     * @Template(":Frontend/Photo:album.html.twig")
     */
    public function albumAction($user_id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $loggedUser = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $requestedUser = $em->find('AppBundle:User', $user_id);
        
        if ($loggedUser === $requestedUser) {            
            $photos = $em->getRepository('AppBundle:Photo')->getAlbum($requestedUser);
            
            return array(
                'photos' => $photos
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
}
