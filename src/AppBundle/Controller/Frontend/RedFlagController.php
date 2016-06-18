<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\RedFlag;
use Symfony\Component\HttpFoundation\Response;

/**
 * RedFlag controller.
 *
 * @Route("/redflag")
 */
class RedFlagController extends Controller
{
    /**
     * Displays a form to edit an existing RedFlag entity.
     *
     * @Route("/{id}/ajax_edit_form", name="ajax_edit_redflag_form", options={"expose"=true})
     * @param int $id RedFlag id
     * @Method({"GET"})
     */
    public function ajaxEditFormAction($id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $redflag = $em->find('AppBundle:RedFlag', $id);

        if ($user === $redflag->getProspect()->getUser()) {          

            $editForm = $this->createForm('AppBundle\Form\RedFlagType', $redflag, array(
                'method' => 'POST',
                'action' => $this->generateUrl('redflag_edit', array('id' => $id))
            ));            

            $editFormView = $this->renderView('Frontend/Redflag/edit.html.twig', array(
                'redflag' => $redflag,
                'edit_form' => $editForm->createView()
            ));
            
            return new Response($editFormView);
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    } 
       
    /**
     * Lists all RedFlag entities.
     *
     * @Route("/", name="redflag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $redFlags = $em->getRepository('AppBundle:RedFlag')->findAll();

        return $this->render('redflag/index.html.twig', array(
            'redFlags' => $redFlags,
        ));
    }

    /**
     * Creates a new RedFlag entity.
     *
     * @Route("/new", name="redflag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $redFlag = new RedFlag();
        $form = $this->createForm('AppBundle\Form\RedFlagType', $redFlag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($redFlag);
            $em->flush();

            return $this->redirectToRoute('redflag_show', array('id' => $redFlag->getId()));
        }

        return $this->render('redflag/new.html.twig', array(
            'redFlag' => $redFlag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RedFlag entity.
     *
     * @Route("/{id}", name="redflag_show")
     * @Method("GET")
     */
    public function showAction(RedFlag $redFlag)
    {
        $deleteForm = $this->createDeleteForm($redFlag);

        return $this->render('redflag/show.html.twig', array(
            'redFlag' => $redFlag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RedFlag entity.
     *
     * @Route("/{id}/edit", name="redflag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $redflag = $em->getRepository('AppBundle:RedFlag')->find($id);

        if ($user === $redflag->getProspect()->getUser()) {
        
//            $deleteForm = $this->createDeleteForm($redflag);
            $editForm = $this->createForm('AppBundle\Form\RedFlagType', $redflag);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($redflag);
                $em->flush();               
            }
            
            return $this->redirectToRoute('prospect_show', array(
                'id' => $redflag->getProspect()->getId(),
                'prospect' => $redflag->getProspect()
            ));
            
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }

    /**
     * Deletes a RedFlag entity.
     *
     * @Route("/{id}", name="redflag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RedFlag $redFlag)
    {
        $form = $this->createDeleteForm($redFlag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($redFlag);
            $em->flush();
        }

        return $this->redirectToRoute('redflag_index');
    }

    /**
     * Creates a form to delete a RedFlag entity.
     *
     * @param RedFlag $redFlag The RedFlag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RedFlag $redFlag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('redflag_delete', array('id' => $redFlag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
