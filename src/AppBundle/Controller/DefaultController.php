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

    public function listLogsAction()
    {
        if (!$this->getUser()) {
            return new Response();
        }
        $em   = $this->getDoctrine()->getManager();
        $logs = $em->getRepository('AppBundle:Log')->getAllLogs($this->getUser());

        return $this->render(':default:listLogs.html.twig', [
            'logs' => $logs,
        ]);


    }


    public function usersAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
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
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        return $this->render('default/my-profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
