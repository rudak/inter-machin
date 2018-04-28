<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\City;
use AppBundle\Entity\Item;
use AppBundle\Services\Action\City\CityHandler;
use AppBundle\Services\Action\User\LevelUp;
use AppBundle\Services\Game\Dice;
use AppBundle\Services\User\RiseAgain;
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
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->getUsersByCity($this->getUser()->getCity());
        return $this->render('default/users.html.twig', [
            'users' => $users,
            'city'  => $this->getUser()->getCity(),
        ]);
    }

    public function gameAction()
    {
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
        dump($this->getUser()->getAlive());
        return $this->render('default/my-profile.html.twig', [
            'user'         => $this->getUser(),
            'items'        => UserItems::getSortedItems($this->getUser()),
            'levelUpPrice' => UserLevel::getLevelUpPrice($this->getUser()),
        ]);
    }

    public function levelUpAction(Request $request)
    {
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
        die('test page');
        return $this->render(':default:test.html.twig');
    }

    public function rankingAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->getBestUsers();

        return $this->render(':default:ranking.html.twig', [
            'users' => $users,
        ]);
    }

    public function citiesAction()
    {
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

    public function deadLandAction()
    {
        $user = $this->getUser();
        return $this->render('default/dead-land.html.twig', [
            'user' => $user,
        ]);
    }

    public function riseAgainAction(Request $request)
    {
        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('rise_again', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas revenir à la vie, token incorrect.');
            return $this->redirectToRoute('homepage');
        }
        $this->get(RiseAgain::class)->execute($this->getUser());
        return $this->redirectToRoute('homepage');
    }
}
