<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\City;
use AppBundle\Form\CityType;

/**
 * City controller.
 *
 */
class CityController extends Controller
{
    const CURRENT_PAGE = '****';
    /**
     * Lists all City entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cities = $em->getRepository('AppBundle:City')->findAll();

        return $this->render('city/index.html.twig', array(
            'cities' => $cities,
            'current_page' => self::CURRENT_PAGE,
        ));
    }
/**
    * Creates a new City entity.
*
    */
    public function newAction(Request $request)
{
    $city = new City();
    $form = $this->createForm('AppBundle\Form\CityType', $city);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    $em = $this->getDoctrine()->getManager();
    $em->persist($city);
    $em->flush();

    return $this->redirectToRoute('admin_city_show', array('id' => $city->getId()));
    }

    return $this->render('city/new.html.twig', array(
    'city' => $city,
    'form' => $form->createView(),
    'current_page' => self::CURRENT_PAGE,
    ));
}
/**
    * Finds and displays a City entity.
*
    */
    public function showAction(City $city)
{
            $deleteForm = $this->createDeleteForm($city);
    
    return $this->render('city/show.html.twig', array(
    'city' => $city,
    'current_page' => self::CURRENT_PAGE,
            'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Displays a form to edit an existing City entity.
     *
     */
    public function editAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $editForm = $this->createForm('AppBundle\Form\CityType', $city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();

            return $this->redirectToRoute('admin_city_edit', array('id' => $city->getId()));
        }

        return $this->render('city/edit.html.twig', array(
            'city' => $city,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'current_page' => self::CURRENT_PAGE,
        ));
    }

    /**
     * Deletes a City entity.
     *
     */
    public function deleteAction(Request $request, City $city)
    {
        $form = $this->createDeleteForm($city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
        }

        return $this->redirectToRoute('admin_city_index');
    }

    /**
     * Creates a form to delete a City entity.
     *
     * @param City $city The City entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
