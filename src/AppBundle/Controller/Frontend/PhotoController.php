<?php
namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Template("AppBundle:Frontend/Photo/gallery.html.twig")
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
                'action' => $this->generateUrl('prospect_update', array('id' => $prospect->getId())),
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
     * Edit photo (for cropping)
     * 
     * @Route("/{id}/edit", name="photo_edit")
     * @Template()
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

            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

            imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $width, $height);
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
}
