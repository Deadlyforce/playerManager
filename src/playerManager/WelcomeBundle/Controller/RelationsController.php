<?php

namespace playerManager\WelcomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use playerManager\WelcomeBundle\Entity\Relations;
use playerManager\WelcomeBundle\Form\RelationsType;

/**
 * Relations controller.
 *
 * @Route("/relations")
 */
class RelationsController extends Controller
{

    /**
     * Lists all Relations entities.
     *
     * @Route("/", name="relations")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('playerManagerWelcomeBundle:Relations')->findAll();
        
        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Creates a new Relations entity.
     *
     * @Route("/", name="relations_create")
     * @Method("POST")
     * @Template("playerManagerWelcomeBundle:Relations:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Relations();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('relations_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Relations entity.
     *
     * @param Relations $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Relations $entity)
    {
        $form = $this->createForm(new RelationsType(), $entity, array(
            'action' => $this->generateUrl('relations_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Relations entity.
     *
     * @Route("/new", name="relations_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Relations();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Relations entity.
     *
     * @Route("/{id}", name="relations_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Relations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Relations entity.
     *
     * @Route("/{id}/edit", name="relations_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Relations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relations entity.');
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
    * Creates a form to edit a Relations entity.
    *
    * @param Relations $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Relations $entity)
    {
        $form = $this->createForm(new RelationsType(), $entity, array(
            'action' => $this->generateUrl('relations_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Relations entity.
     *
     * @Route("/{id}", name="relations_update")
     * @Method("PUT")
     * @Template("playerManagerWelcomeBundle:Relations:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Relations')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Relations entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('relations_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Relations entity.
     *
     * @Route("/{id}", name="relations_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('playerManagerWelcomeBundle:Relations')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Relations entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('relations'));
    }

    /**
     * Creates a form to delete a Relations entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('relations_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
