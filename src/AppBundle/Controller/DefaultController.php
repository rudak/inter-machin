<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', []);
    }


    public function usersAction()
    {
        if (!$user = $this->getUser()) {
            $this->addFlash('danger', 'Vous devez etre authentifié pour accéder a cette page');
            return $this->redirectToRoute('homepage');
        }
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();
        return $this->render('default/users.html.twig', [
            'users' => $users,
        ]);
    }


    public function userAction($id)
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id);
        if ($user == $this->getUser()) {
            return $this->redirectToRoute('myProfile');
        }
        return $this->render('default/user.html.twig', [
            'user' => $user,
        ]);
    }

    public function myProfileAction()
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Vous devez etre authentifié pour accéder a cette page');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/my-profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
