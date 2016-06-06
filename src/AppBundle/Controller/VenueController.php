<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Venue;
use AppBundle\Form\VenueType;

/**
 * Venue controller.
 *
 * @Route("/venue")
 */
class VenueController extends Controller
{
    /**
     * Lists all Venue entities.
     *
     * @Route("/", name="venue_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $venues = $em->getRepository('AppBundle:Venue')->findAll();

        return $this->render('venue/index.html.twig', array(
            'venues' => $venues,
        ));
    }

    /**
     * Creates a new Venue entity.
     *
     * @Route("/new", name="venue_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $venue = new Venue();
        $form = $this->createForm('AppBundle\Form\VenueType', $venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            return $this->redirectToRoute('venue_show', array('id' => $venue->getId()));
        }

        return $this->render('venue/new.html.twig', array(
            'venue' => $venue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Venue entity.
     *
     * @Route("/{id}", name="venue_show")
     * @Method("GET")
     */
    public function showAction(Venue $venue)
    {
        $deleteForm = $this->createDeleteForm($venue);

        return $this->render('venue/show.html.twig', array(
            'venue' => $venue,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Venue entity.
     *
     * @Route("/{id}/edit", name="venue_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Venue $venue)
    {
        $deleteForm = $this->createDeleteForm($venue);
        $editForm = $this->createForm('AppBundle\Form\VenueType', $venue);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($venue);
            $em->flush();

            return $this->redirectToRoute('venue_edit', array('id' => $venue->getId()));
        }

        return $this->render('venue/edit.html.twig', array(
            'venue' => $venue,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Venue entity.
     *
     * @Route("/{id}", name="venue_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Venue $venue)
    {
        $form = $this->createDeleteForm($venue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($venue);
            $em->flush();
        }

        return $this->redirectToRoute('venue_index');
    }

    /**
     * Creates a form to delete a Venue entity.
     *
     * @param Venue $venue The Venue entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Venue $venue)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('venue_delete', array('id' => $venue->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
