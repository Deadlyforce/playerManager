<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Rating;
use AppBundle\Entity\Prospect;
use AppBundle\Form\RatingType;

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
    public function indexAction($prospect_id)
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('AppBundle:Rating')->findAll();

        return $this->render('Frontend/rating/index.html.twig', array(
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

            return $this->render('Frontend/rating/show.html.twig', array(
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
     * @Route("/edit/{prospect_id}", name="rating_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $prospect_id)
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
            $editForm = $this->createForm('AppBundle\Form\RatingType', $rating);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {                
                $em->persist($rating);
                $em->flush();

                return $this->redirectToRoute('rating_edit', array('prospect_id' => $rating->getProspect()->getId()));
            }

            return $this->render('Frontend/rating/edit.html.twig', array(
                'rating' => $rating,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
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