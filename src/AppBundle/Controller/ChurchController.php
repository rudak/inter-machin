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
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        return $this->render(':church:church.html.twig');
    }

    public function churchPrayAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $this->get(PrayHandler::class)->execute($this->getUser());
        return $this->redirectToRoute('church_index');
    }

    public function churchStealAction(SessionInterface $session)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $this->get(StealQuestHandler::class)->execute($this->getUser());
        return $this->redirectToRoute('church_index');
    }
}