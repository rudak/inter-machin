<?php

namespace AppBundle\Controller;

use AppBundle\Services\Action\Church\PrayHandler;
use AppBundle\Services\Action\Church\StealQuestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class ChurchController extends Controller
{

    public function churchIndexAction()
    {
        return $this->render(':church:church.html.twig');
    }

    public function churchPrayAction()
    {
        $this->get(PrayHandler::class)->execute($this->getUser());
        return $this->redirectToRoute('church_index');
    }

    public function churchStealAction(SessionInterface $session)
    {
        $this->get(StealQuestHandler::class)->execute($this->getUser());
        return $this->redirectToRoute('church_index');
    }
}