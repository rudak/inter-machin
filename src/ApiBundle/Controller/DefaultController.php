<?php

namespace ApiBundle\Controller;

use AppBundle\Services\Data\DataGrabber;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function bankDataAction()
    {
        $data = $this->get(DataGrabber::class)->getAccountData($this->getUser());
        return new JsonResponse($data, 200);
    }

    public function bankUsersAccountsAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getAccountsData(), 200);
    }

    public function game_oneTenDataAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getGameOneTenData(), 200);
    }

    public function gameDicesDataAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getGameDicesData(), 200);
    }

    public function purchaseDataAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getpurchaseData(), 200);
    }

    public function resourceEvolutionAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getResourceEvolutionData(), 200);
    }

    public function userMoneyDataAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getUsersMoneyData(), 200);
    }

    public function userLevelsAction()
    {
        return new JsonResponse($this->get(DataGrabber::class)->getLevelsData(), 200);
    }
}
