<?php

namespace ApiBundle\Controller;

use AppBundle\Services\Data\DataGrabber;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function bankDataAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        $data = $this->get(DataGrabber::class)->getAccountData($this->getUser());
        return new JsonResponse($data, 200);
    }

    public function bankUsersAccountsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getAccountsData(), 200);
    }

    public function game_oneTenDataAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getGameOneTenData(), 200);
    }

    public function gameDicesDataAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getGameDicesData(), 200);
    }

    public function purchaseDataAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getpurchaseData(), 200);
    }

    public function userMoneyDataAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getUsersMoneyData(), 200);
    }

    public function userLevelsAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Vous devez etre authentifié pour accéder a ce contenu !');
        return new JsonResponse($this->get(DataGrabber::class)->getLevelsData(), 200);
    }
}
