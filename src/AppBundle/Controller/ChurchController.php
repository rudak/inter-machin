<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Bank\Refund;
use AppBundle\Form\Bank\LoanRefundType;
use AppBundle\Form\Bank\LoanType;
use AppBundle\Services\Bank\BankHandler;
use AppBundle\Utils\Bank\LoansHanlder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChurchController extends Controller
{

    public function churchIndexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        return $this->render(':church:church.html.twig');
    }

    public function churchPrayAction(SessionInterface $session)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        if (mt_rand(1, 10) < 6) {
            $session->getFlashBag()->add('warning', sprintf("Dommage Dieu ne vous à pas écouté ..|"));
            return $this->redirectToRoute('church_index');
        }
        $session->getFlashBag()->add('success', sprintf("Vous avez récupéré 1 PA"));
        return $this->redirectToRoute('church_index');
    }

    public function churchStealAction(SessionInterface $session)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        if (mt_rand(1, 10) < 6) {
            $session->getFlashBag()->add('warning', sprintf("Vous vous êtes fait prendre la main dans le sac !"));
            return $this->redirectToRoute('church_index');
        }
        $monneySteal = mt_rand(1, 100);
        $session->getFlashBag()->add('success', sprintf("Vous avez réussis à volé %d", $monneySteal));
        return $this->redirectToRoute('church_index');
    }
}