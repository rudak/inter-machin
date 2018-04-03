<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Item;
use AppBundle\Form\Bank\LoanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BankController extends Controller
{

    public function indexAction()
    {
        return $this->render(':default:bank.html.twig', []);
    }

    public function newLoanAction()
    {
        $loan = new Loan($this->getUser());
        $form = $this->getLoanForm($loan);
        return $this->render('bank/new_loan.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getLoanForm(Loan $loan)
    {
        return $this->createForm(LoanType::class, $loan, [
            'action' => $this->generateUrl('bank_request'),
            'method' => 'POST',
        ]);
    }
}
