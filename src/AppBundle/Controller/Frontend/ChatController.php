<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Chat;
use AppBundle\Form\ChatType;




/**
 * Chat controller.
 *
 * @Route("/chat")
 */
class ChatController extends Controller
{

    /**
     * Lists all Chat entities.
     *
     * @Route("/", name="chat")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Echange')->findAll();        
        
        return array(
            'entities' => $entities
        );
    }
    
    /**
     * Creates a new Chat entity.
     *
     * @Route("/", name="chat_create")
     * @Method("POST")
     * @Template(":Frontend/Chat:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Chat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);       

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('chat_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Chat entity.
     *
     * @param Chat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Chat $entity)
    {
        $form = $this->createForm(new ChatType(), $entity, array(
            'action' => $this->generateUrl('echange_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Chat entity.
     *
     * @Route("/new", name="echange_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Chat();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Chat entity.
     *
     * @Route("/{id}", name="chat_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Chat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chat entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Chat entity.
     *
     * @Route("/{id}/edit", name="chat_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Chat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Chat entity.');
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
    * Creates a form to edit a Chat entity.
    *
    * @param Chat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Chat $entity)
    {
        $form = $this->createForm(new ChatType(), $entity, array(
            'action' => $this->generateUrl('echange_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Chat entity.
     *
     * @Route("/{id}", name="chat_update")
     * @Method("PUT")
     * @Template(":Frontend:Chat:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Chat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Echange entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('chat_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Chat entity.
     *
     * @Route("/{id}", name="chat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Chat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Chat entity.');
            }            

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('chat'));
    }

    /**
     * Creates a form to delete a Chat entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chat_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
