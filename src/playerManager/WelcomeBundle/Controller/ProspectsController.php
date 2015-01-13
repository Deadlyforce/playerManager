<?php

namespace playerManager\WelcomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use playerManager\WelcomeBundle\Entity\Prospects;
use playerManager\WelcomeBundle\Form\ProspectsType;

/**
 * Prospects controller.
 *
 * @Route("/prospects")
 */
class ProspectsController extends Controller
{

    /**
     * Lists all Prospects entities.
     *
     * @Route("/", name="prospects")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('playerManagerWelcomeBundle:Prospects')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Prospects entity.
     *
     * @Route("/", name="prospects_create")
     * @Method("POST")
     * @Template("playerManagerWelcomeBundle:Prospects:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Prospects();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prospects_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Prospects entity.
     *
     * @param Prospects $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Prospects $entity)
    {
        $form = $this->createForm(new ProspectsType(), $entity, array(
            'action' => $this->generateUrl('prospects_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Créer ce contact',
            'attr' => array(
                'class' => 'btn btn-default'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Prospects entity.
     *
     * @Route("/new", name="prospects_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Prospects();

        // Définition des paramètres par défaut
        $entity->setAge(23);
        
        $datetime =  new \DateTime('', new \DateTimeZone('Europe/Paris'));
        $entity->setDateCreation($datetime);

        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prospects entity.
     *
     * @Route("/{id}", name="prospects_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prospects entity.
     *
     * @Route("/{id}/edit", name="prospects_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
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
    * Creates a form to edit a Prospects entity.
    *
    * @param Prospects $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Prospects $entity)
    {
        $form = $this->createForm(new ProspectsType(), $entity, array(
            'action' => $this->generateUrl('prospects_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Prospects entity.
     *
     * @Route("/{id}", name="prospects_update")
     * @Method("PUT")
     * @Template("playerManagerWelcomeBundle:Prospects:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prospects entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();

            return $this->redirect($this->generateUrl('prospects_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Prospects entity.
     *
     * @Route("/{id}", name="prospects_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('playerManagerWelcomeBundle:Prospects')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prospects entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('prospects'));
    }

    /**
     * Creates a form to delete a Prospects entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prospects_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
