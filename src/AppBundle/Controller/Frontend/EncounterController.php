<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Encounter;
use AppBundle\Form\EncounterType;

/**
 * Encounter controller.
 *
 * @Route("/encounter")
 */
class EncounterController extends Controller
{

    /**
     * Lists all Encounter entities for a specific prospect
     *
     * @Route("/{prospect_id}", name="encounter")
     * @Method("GET")
     * @Template(":Frontend/Encounter:index.html.twig")
     */
    public function indexAction($prospect_id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository("AppBundle:Prospect")->find($prospect_id);
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        if ($user === $prospect->getUser()) {       
            
            $encounters = $em->getRepository('AppBundle:Encounter')->findBy(array("prospect" => $prospect));

            return array(
                'encounters' => $encounters,
                'prospect' => $prospect
            );
        } else {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
    }
    /**
     * Creates a new Encounter entity.
     *
     * @Route("/", name="encounter_create")
     * @Method("POST")
     * @Template(":Frontend/Encounter:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Encounter();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('encounter_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Encounter entity.
     *
     * @Route("/new/{prospect_id}", name="encounter_new")
     * @param int $prospect_id
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $prospect_id)
    {
        $encounter = new Encounter();
        
        $form = $this->createForm(EncounterType::class, $encounter);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($encounter);
            $em->flush();
            
            return $this->redirectToRoute('encounter', array('prospect_id' => $prospect_id));
        }
        
        return $this->render(':Frontend/Encounter:new.html.twig', array(
            'encounter' => $encounter,
            'prospect_id' => $prospect_id,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a Encounter entity.
     *
     * @Route("/{id}", name="encounter_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Encounter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Encounter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Encounter entity.
     *
     * @Route("/{id}/edit", name="encounter_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Encounter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Encounter entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Encounter entity.
    *
    * @param Encounter $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Encounter $entity)
    {
        $form = $this->createForm(new EncounterType(), $entity, array(
            'action' => $this->generateUrl('encounter_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Encounter entity.
     *
     * @Route("/{id}", name="encounter_update")
     * @Method("PUT")
     * @Template(":Frontend/Encounter:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Encounter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Encounter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('encounter_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Encounter entity.
     *
     * @Route("/{id}", name="encounter_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Encounter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Encounter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('encounter'));
    }

    /**
     * Creates a form to delete a Encounter entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('encounter_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
