<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UserBundle\Entity\User;
use UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    const CURRENT_PAGE = 'user';

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->getAllUsersForAdmin();

        return $this->render('user/index.html.twig', [
            'users'        => $users,
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Creates a new User entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app_password_encoder')->encodePasswordForUser($user);
            $user->setDateOfBirth(new \Datetime('NOW'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_show', ['id' => $user->getId()]);
        }

        return $this->render('user/new.html.twig', [
            'user'         => $user,
            'form'         => $form->createView(),
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', [
            'user'         => $user,
            'current_page' => self::CURRENT_PAGE,
            'delete_form'  => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm   = $this->createForm('UserBundle\Form\UserType', $user, ['mode' => 'edit']);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user'         => $user,
            'edit_form'    => $editForm->createView(),
            'delete_form'  => $deleteForm->createView(),
            'current_page' => self::CURRENT_PAGE,
        ]);
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_user_delete', ['id' => $user->getId()]))
                    ->setMethod('DELETE')
                    ->getForm()
            ;
    }
}
