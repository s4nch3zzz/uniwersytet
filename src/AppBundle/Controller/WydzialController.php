<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Wydzial;
use AppBundle\Form\WydzialType;

/**
 * Wydzial controller.
 *
 * @Route("/admin/wydzial")
 */
class WydzialController extends Controller
{

    /**
     * Lists all Wydzial entities.
     *
     * @Route("/", name="admin_wydzial")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Wydzial')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Wydzial entity.
     *
     * @Route("/", name="admin_wydzial_create")
     * @Method("POST")
     * @Template("AppBundle:Wydzial:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Wydzial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_wydzial_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Wydzial entity.
     *
     * @param Wydzial $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Wydzial $entity)
    {
        $form = $this->createForm(new WydzialType(), $entity, array(
            'action' => $this->generateUrl('admin_wydzial_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Wydzial entity.
     *
     * @Route("/new", name="admin_wydzial_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Wydzial();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Wydzial entity.
     *
     * @Route("/{id}", name="admin_wydzial_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Wydzial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wydzial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Wydzial entity.
     *
     * @Route("/{id}/edit", name="admin_wydzial_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Wydzial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wydzial entity.');
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
    * Creates a form to edit a Wydzial entity.
    *
    * @param Wydzial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Wydzial $entity)
    {
        $form = $this->createForm(new WydzialType(), $entity, array(
            'action' => $this->generateUrl('admin_wydzial_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Wydzial entity.
     *
     * @Route("/{id}", name="admin_wydzial_update")
     * @Method("PUT")
     * @Template("AppBundle:Wydzial:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Wydzial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wydzial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_wydzial_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Wydzial entity.
     *
     * @Route("/{id}", name="admin_wydzial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Wydzial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Wydzial entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_wydzial'));
    }

    /**
     * Creates a form to delete a Wydzial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_wydzial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
