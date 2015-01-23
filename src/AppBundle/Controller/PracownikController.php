<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pracownik;
use AppBundle\Form\PracownikType;

/**
 * Pracownik controller.
 *
 * @Route("/admin/pracownik")
 */
class PracownikController extends Controller
{

    /**
     * Lists all Pracownik entities.
     *
     * @Route("/", name="admin_pracownik")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pracownik')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Pracownik entity.
     *
     * @Route("/", name="admin_pracownik_create")
     * @Method("POST")
     * @Template("AppBundle:Pracownik:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pracownik();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pracownik_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pracownik entity.
     *
     * @param Pracownik $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pracownik $entity)
    {
        $form = $this->createForm(new PracownikType(), $entity, array(
            'action' => $this->generateUrl('admin_pracownik_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pracownik entity.
     *
     * @Route("/new", name="admin_pracownik_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Pracownik();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Pracownik entity.
     *
     * @Route("/{id}", name="admin_pracownik_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pracownik')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pracownik entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pracownik entity.
     *
     * @Route("/{id}/edit", name="admin_pracownik_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pracownik')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pracownik entity.');
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
    * Creates a form to edit a Pracownik entity.
    *
    * @param Pracownik $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pracownik $entity)
    {
        $form = $this->createForm(new PracownikType(), $entity, array(
            'action' => $this->generateUrl('admin_pracownik_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pracownik entity.
     *
     * @Route("/{id}", name="admin_pracownik_update")
     * @Method("PUT")
     * @Template("AppBundle:Pracownik:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pracownik')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pracownik entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_pracownik_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Pracownik entity.
     *
     * @Route("/{id}", name="admin_pracownik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pracownik')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pracownik entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_pracownik'));
    }

    /**
     * Creates a form to delete a Pracownik entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pracownik_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
