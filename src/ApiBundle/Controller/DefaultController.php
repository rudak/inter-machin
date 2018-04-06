<?php

namespace ApiBundle\Controller;

use AppBundle\Services\Bank\DataGrabber;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function bankDataAction()
    {
        $myAccountData = $this->get(DataGrabber::class)->getAccountData($this->getUser());
        return new JsonResponse($myAccountData, 200);
    }

    public function userMoneyDataAction()
    {
        $usersMoneyData = $this->get(DataGrabber::class)->getUsersMoneyData();
        return new JsonResponse($usersMoneyData, 200);
    }
}
