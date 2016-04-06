<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Rencontre;
use AppBundle\Form\RencontreType;

/**
 * Rencontre controller.
 *
 * @Route("/rencontre")
 */
class RencontreController extends Controller
{

    /**
     * Lists all Rencontre entities.
     *
     * @Route("/", name="rencontre")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Rencontre')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Rencontre entity.
     *
     * @Route("/", name="rencontre_create")
     * @Method("POST")
     * @Template("AppBundle:Rencontre:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Rencontre();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rencontre_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Rencontre entity.
     *
     * @param Rencontre $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Rencontre $entity)
    {
        $form = $this->createForm(new RencontreType(), $entity, array(
            'action' => $this->generateUrl('rencontre_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer'));

        return $form;
    }

    /**
     * Displays a form to create a new Rencontre entity.
     *
     * @Route("/new/{prospect_id}", name="rencontre_new")
     * @param int $prospect_id Prospect id
     * @Method("GET")
     * @Template()
     */
    public function newAction($prospect_id)
    {
        $rencontre = new Rencontre();
        
        $em = $this->getDoctrine()->getManager();
        $prospect = $em->getRepository("AppBundle:Prospect")->find($prospect_id);
        $rencontre->setProspect($prospect);
        
        $form = $this->createCreateForm($rencontre);

        return array(
            'rencontre' => $rencontre,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Rencontre entity.
     *
     * @Route("/{id}", name="rencontre_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Rencontre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rencontre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Rencontre entity.
     *
     * @Route("/{id}/edit", name="rencontre_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Rencontre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rencontre entity.');
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
    * Creates a form to edit a Rencontre entity.
    *
    * @param Rencontre $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Rencontre $entity)
    {
        $form = $this->createForm(new RencontreType(), $entity, array(
            'action' => $this->generateUrl('rencontre_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Rencontre entity.
     *
     * @Route("/{id}", name="rencontre_update")
     * @Method("PUT")
     * @Template("AppBundle:Rencontre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Rencontre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Rencontre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('rencontre_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Rencontre entity.
     *
     * @Route("/{id}", name="rencontre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Rencontre')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Rencontre entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('rencontre'));
    }

    /**
     * Creates a form to delete a Rencontre entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rencontre_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
