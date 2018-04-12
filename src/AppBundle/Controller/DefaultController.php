<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', []);
    }

    public function listLogsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em   = $this->getDoctrine()->getManager();
        $logs = $em->getRepository('AppBundle:Log')->getAllLogs($this->getUser());
        return $this->render(':default:listLogs.html.twig', [
            'logs' => $logs,
        ]);
    }

    /**
     * Lister les users qu'il y a dans la ville
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function usersAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->getUsersByCity($this->getUser()->getCity());
        return $this->render('default/users.html.twig', [
            'users' => $users,
            'city'  => $this->getUser()->getCity(),
        ]);
    }

    public function gameAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        return $this->render(':default:game.html.twig');
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

    public function testAction()
    {
        $agi1 = 0;
        $agi2 = 0;

        $chanceVoleur = 10 * 2.9901 / log10($agi1 + 12);
        $chanceVoler  = 5 * 2.9901 / log10($agi2 + 12);

        $chanceBase = ($chanceVoler / $chanceVoleur) * 100;

        $p = rand(0, 99);

        if ($p < $chanceBase) {
            echo 'Je vole';
        }
        dump($chanceBase);
        die;

        return $this->render(':default:test.html.twig');
    }

    public function rankingAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->getBestUsers();

        return $this->render(':default:ranking.html.twig', [
            'users' => $users,
        ]);
    }

    public function citiesAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em     = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('AppBundle:City')->getCities();
        // dump($cities);
        return $this->render(':default:cities.html.twig', [
            'cities' => $cities,
        ]);
    }


}
