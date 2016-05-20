<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Rating;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rating controller.
 *
 * @Route("/rating")
 */
class RatingController extends Controller
{
    /**
     * Lists all Rating entities.
     *
     * @Route("/", name="rating_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('AppBundle:Rating')->findAll();

        return $this->render('Frontend/Rating/index.html.twig', array(
            'ratings' => $ratings,
        ));
    }

    /**
     * Creates a new Rating entity.
     *
     * @Route("/new", name="rating_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rating = new Rating();
        $form = $this->createForm('AppBundle\Form\RatingType', $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush();

            return $this->redirectToRoute('rating_show', array('id' => $rating->getId()));
        }

        return $this->render('Frontend/rating/new.html.twig', array(
            'rating' => $rating,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Rating entity.
     *
     * @Route("/show/{prospect_id}", name="rating_show")
     * @Method("GET")
     */
    public function showAction($prospect_id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->find('AppBundle:Prospect', $prospect_id);
        
        if ($user === $prospect->getUser()) {
            $rating = $em->getRepository('AppBundle:Rating')->findOneBy(array('prospect' => $prospect));
        
            $deleteForm = $this->createDeleteForm($rating);

            return $this->render('Frontend/Rating/show.html.twig', array(
                'rating' => $rating,
                'delete_form' => $deleteForm->createView(),
            ));
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }       
    }

    /**
     * Displays a form to edit an existing Rating entity.
     *
     * @Route("/{id}/ajax_edit_form", name="ajax_edit_rating_form", options={"expose"=true})
     * @param int $id Rating id
     * @Method({"GET"})
     */
    public function ajaxEditFormAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $rating = $em->find('AppBundle:Rating', $id);

        if ($user === $rating->getProspect()->getUser()) {          

            $editForm = $this->createForm('AppBundle\Form\RatingType', $rating, array(
                'method' => 'PUT'
            ));            

            $editFormView = $this->renderView('Frontend/Rating/edit.html.twig', array(
                'rating' => $rating,
                'edit_form' => $editForm->createView()
            ));
            
            return new Response($editFormView);
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }    
    
    /**
     * Edits an existing Rating entity.
     *
     * @Route("/{id}/edit", name="ajax_edit_rating", options={"expose"=true})
     * @Method({"PUT"})
     */
    public function ajaxEditAction(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $rating = $em->getRepository('AppBundle:Rating')->find($id);

        if ($user === $rating->getProspect()->getUser()) { 

            $editForm = $this->createForm('AppBundle\Form\RatingType', $rating, array(
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
     * Deletes a Rating entity.
     *
     * @Route("/{id}", name="rating_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rating $rating)
    {
        $form = $this->createDeleteForm($rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rating);
            $em->flush();
        }

        return $this->redirectToRoute('rating_index');
    }

    /**
     * Creates a form to delete a Rating entity.
     *
     * @param Rating $rating The Rating entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rating $rating)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rating_delete', array('id' => $rating->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
