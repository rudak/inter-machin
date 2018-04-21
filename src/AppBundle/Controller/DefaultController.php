<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\City;
use AppBundle\Entity\Item;
use AppBundle\Services\Action\City\CityHandler;
use AppBundle\Services\Action\User\LevelUp;
use AppBundle\Services\Game\Dice;
use AppBundle\Utils\User\UserItems;
use AppBundle\Utils\User\UserLevel;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', []);
    }

    public function listActionsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em = $this->getDoctrine()->getManager();
        return $this->render(':default:listLogs.html.twig', [
            'logs' => [],
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
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
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
            'user'         => $this->getUser(),
            'items'        => UserItems::getSortedItems($this->getUser()),
            'levelUpPrice' => UserLevel::getLevelUpPrice($this->getUser()),
        ]);
    }

    public function levelUpAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $submittedToken = $request->request->get('_csrf_token');
        if (!$this->isCsrfTokenValid('levelUp', $submittedToken)) {
            $this->addFlash('danger', 'Jeton CSRF invalide pour le level up, attention...');
            return $this->redirectToRoute('myProfile');
        }
        $this->get(LevelUp::class)->execute($this->getUser());
        return $this->redirectToRoute('myProfile');
    }

    public function testAction()
    {
//        $agi1 = 0;
//        $agi2 = 0;
//
//        $chanceVoleur = 10 * 2.9901 / log10($agi1 + 12);
//        $chanceVoler  = 5 * 2.9901 / log10($agi2 + 12);
//
//        $chanceBase = ($chanceVoler / $chanceVoleur) * 100;
//
//        $p = rand(0, 99);
//
//        if ($p < $chanceBase) {
//            echo 'Je vole';
//        }
//        dump($chanceBase);
//        die;

        $dices = $this->get(Dice    ::class)->execute($this->getUser(), 100);
        dump($dices);
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
        return $this->render(':default:cities.html.twig', [
            'cities' => $cities,
        ]);
    }

    public function cityAction($id)
    {
        $em   = $this->getDoctrine()->getManager();
        $city = $em->getRepository(City::class)->find($id);
        if (!$city) {
            throw new EntityNotFoundException(sprintf("La ville avec l'ID #%d est introuvable.", $id));
        }
        return $this->render(':default:city.html.twig', ['city' => $city]);
    }

    public function cityMoveAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        $submittedToken = $request->request->get('_csrf_token');
        if (!$this->isCsrfTokenValid('cityMove', $submittedToken)) {
            $this->addFlash('danger', 'Jeton CSRF invalide, attention...');
            return $this->redirectToRoute('cities');
        }

        $em   = $this->getDoctrine()->getManager();
        $city = $em->getRepository(City::class)->find($request->get('cityID'));

        if (!$city) {
            throw new EntityNotFoundException(sprintf("La ville avec l'ID #%d est introuvable.", $request->get('cityID')));
        }

        $this->get(CityHandler::class)->move($this->getUser(), $city);
        $em->flush();

        return $this->redirectToRoute('cities');
    }
}
