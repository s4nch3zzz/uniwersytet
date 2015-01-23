<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pokoj;
use AppBundle\Form\PokojType;

/**
 * Pokoj controller.
 *
 * @Route("/admin/pokoj")
 */
class PokojController extends Controller
{

    /**
     * Lists all Pokoj entities.
     *
     * @Route("/", name="admin_pokoj")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pokoj')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pokoj entity.
     *
     * @Route("/", name="admin_pokoj_create")
     * @Method("POST")
     * @Template("AppBundle:Pokoj:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pokoj();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pokoj_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pokoj entity.
     *
     * @param Pokoj $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pokoj $entity)
    {
        $form = $this->createForm(new PokojType(), $entity, array(
            'action' => $this->generateUrl('admin_pokoj_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pokoj entity.
     *
     * @Route("/new", name="admin_pokoj_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pokoj();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pokoj entity.
     *
     * @Route("/{id}", name="admin_pokoj_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pokoj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pokoj entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pokoj entity.
     *
     * @Route("/{id}/edit", name="admin_pokoj_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pokoj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pokoj entity.');
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
    * Creates a form to edit a Pokoj entity.
    *
    * @param Pokoj $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pokoj $entity)
    {
        $form = $this->createForm(new PokojType(), $entity, array(
            'action' => $this->generateUrl('admin_pokoj_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pokoj entity.
     *
     * @Route("/{id}", name="admin_pokoj_update")
     * @Method("PUT")
     * @Template("AppBundle:Pokoj:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pokoj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pokoj entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pokoj_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pokoj entity.
     *
     * @Route("/{id}", name="admin_pokoj_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pokoj')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pokoj entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pokoj'));
    }

    /**
     * Creates a form to delete a Pokoj entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pokoj_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
