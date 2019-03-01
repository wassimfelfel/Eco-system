<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typeproduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeproduit controller.
 *
 * @Route("admin/typeproduit")
 */
class TypeproduitController extends Controller
{
    /**
     * Lists all typeproduit entities.
     *
     * @Route("/", name="admin_typeproduit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeproduits = $em->getRepository('AppBundle:Typeproduit')->findAll();

        return $this->render('typeproduit/index.html.twig', array(
            'typeproduits' => $typeproduits,
        ));
    }

    /**
     * Creates a new typeproduit entity.
     *
     * @Route("/new", name="admin_typeproduit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeproduit = new Typeproduit();
        $form = $this->createForm('AppBundle\Form\TypeproduitType', $typeproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeproduit);
            $em->flush();

            return $this->redirectToRoute('admin_typeproduit_show', array('id' => $typeproduit->getId()));
        }

        return $this->render('typeproduit/new.html.twig', array(
            'typeproduit' => $typeproduit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeproduit entity.
     *
     * @Route("/{id}", name="admin_typeproduit_show")
     * @Method("GET")
     */
    public function showAction(Typeproduit $typeproduit)
    {
        $deleteForm = $this->createDeleteForm($typeproduit);

        return $this->render('typeproduit/show.html.twig', array(
            'typeproduit' => $typeproduit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeproduit entity.
     *
     * @Route("/{id}/edit", name="admin_typeproduit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typeproduit $typeproduit)
    {
        $deleteForm = $this->createDeleteForm($typeproduit);
        $editForm = $this->createForm('AppBundle\Form\TypeproduitType', $typeproduit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typeproduit_edit', array('id' => $typeproduit->getId()));
        }

        return $this->render('typeproduit/edit.html.twig', array(
            'typeproduit' => $typeproduit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeproduit entity.
     *
     * @Route("/delete/{id}", name="admin_typeproduit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typeproduit $typeproduit)
    {
        $form = $this->createDeleteForm($typeproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeproduit);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typeproduit_index');
    }

    /**
     * Creates a form to delete a typeproduit entity.
     *
     * @param Typeproduit $typeproduit The typeproduit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typeproduit $typeproduit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typeproduit_delete', array('id' => $typeproduit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
