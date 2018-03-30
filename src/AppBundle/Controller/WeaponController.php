<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Weapon;
use AppBundle\Form\WeaponType;

/**
 * Weapon controller.
 *
 */
class WeaponController extends Controller
{
    const CURRENT_PAGE = '****';

    /**
     * Lists all Weapon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $weapons = $em->getRepository('AppBundle:Weapon')->findAll();

        return $this->render('weapon/index.html.twig', [
            'weapons'      => $weapons,
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Creates a new Weapon entity.
     *
     */
    public function newAction(Request $request)
    {
        $weapon = new Weapon();
        $form   = $this->createForm('AppBundle\Form\WeaponType', $weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($weapon);
            $em->flush();

            return $this->redirectToRoute('admin_weapon_show', ['id' => $weapon->getId()]);
        }

        return $this->render('weapon/new.html.twig', [
            'weapon'       => $weapon,
            'form'         => $form->createView(),
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Finds and displays a Weapon entity.
     *
     */
    public function showAction(Weapon $weapon)
    {
        $deleteForm = $this->createDeleteForm($weapon);

        return $this->render('weapon/show.html.twig', [
            'weapon'       => $weapon,
            'current_page' => self::CURRENT_PAGE,
            'delete_form'  => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing Weapon entity.
     *
     */
    public function editAction(Request $request, Weapon $weapon)
    {
        $deleteForm = $this->createDeleteForm($weapon);
        $editForm   = $this->createForm('AppBundle\Form\WeaponType', $weapon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($weapon);
            $em->flush();

            return $this->redirectToRoute('admin_weapon_edit', ['id' => $weapon->getId()]);
        }

        return $this->render('weapon/edit.html.twig', [
            'weapon'       => $weapon,
            'edit_form'    => $editForm->createView(),
            'delete_form'  => $deleteForm->createView(),
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Deletes a Weapon entity.
     *
     */
    public function deleteAction(Request $request, Weapon $weapon)
    {
        $form = $this->createDeleteForm($weapon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($weapon);
            $em->flush();
        }

        return $this->redirectToRoute('admin_weapon_index');
    }

    /**
     * Creates a form to delete a Weapon entity.
     *
     * @param Weapon $weapon The Weapon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Weapon $weapon)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_weapon_delete', ['id' => $weapon->getId()]))
                    ->setMethod('DELETE')
                    ->getForm()
            ;
    }
}
