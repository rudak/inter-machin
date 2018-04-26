<?php

namespace AppBundle\Controller;

use AppBundle\Services\Game\Dice;
use AppBundle\Services\Game\OneTen;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{

    public function oneTenAction(Request $request, $amount)
    {
        if (in_array($amount, [1, 5, 10, 100, 500])) {
            $this->get(OneTen::class)->execute($this->getUser(), $amount);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('game_index');
    }

    public function diceAction(Request $request, $amount)
    {
        if (in_array($amount, [1, 5, 10, 100, 500])) {
            $this->get(Dice::class)->execute($this->getUser(), $amount);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('game_index');
    }
}
