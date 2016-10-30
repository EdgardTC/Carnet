<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Menbers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
//use Symfony\Component\Form\Extension\Core\Type\IntegerType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Menber controller.
 *
 * @Route("menbers")
 */
class MenbersController extends Controller
{
    /**
     * Lists all menber entities.
     *
     * @Route("/", name="menbers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menbers = $em->getRepository('AppBundle:Menbers')->findAll();

        return $this->render('menbers/index.html.twig', array(
            'menbers' => $menbers,
        ));
    }

    /**
     * Creates a new menber entity.
     *
     * @Route("/new", name="menbers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $menber = new Menbers();
        $form = $this->createForm('AppBundle\Form\MenbersType', $menber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menber);
            $em->flush($menber);

            return $this->redirectToRoute('menbers_show', array('id' => $menber->getId()));
        }

        return $this->render('menbers/new.html.twig', array(
            'menber' => $menber,
            'form' => $form->createView(),
        ));

    }

    /**
     * Finds and displays a menber entity.
     *
     * @Route("/{id}", name="menbers_show")
     * @Method("GET")
     */
    public function showAction(Menbers $menber)
    {
        $deleteForm = $this->createDeleteForm($menber);

        return $this->render('menbers/show.html.twig', array(
            'menber' => $menber,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing menber entity.
     *
     * @Route("/{id}/edit", name="menbers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Menbers $menber)
    {
        $deleteForm = $this->createDeleteForm($menber);
        $editForm = $this->createForm('AppBundle\Form\MenbersType', $menber);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menbers_edit', array('id' => $menber->getId()));
        }

        return $this->render('menbers/edit.html.twig', array(
            'menber' => $menber,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a menber entity.
     *
     * @Route("/{id}", name="menbers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Menbers $menber)
    {
        $form = $this->createDeleteForm($menber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menber);
            $em->flush($menber);
        }

        return $this->redirectToRoute('menbers_index');
    }

    /**
     * Creates a form to delete a menber entity.
     *
     * @param Menbers $menber The menber entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Menbers $menber)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('menbers_delete', array('id' => $menber->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
