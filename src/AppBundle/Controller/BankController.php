<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Account;
use AppBundle\Entity\Bank\Loan;
use AppBundle\Form\Bank\LoanType;
use AppBundle\Services\Bank\BankHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BankController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em    = $this->getDoctrine()->getManager();
        $loans = $em->getRepository(Loan::class)->findAllLoansByUser($this->getUser());

        $account = new Account($this->getUser());
        $account->hydratAccount($loans);

        $em->persist($account);
        $em->flush();
        return $this->render(':default:bank.html.twig', [
            'loans' => $loans,
        ]);
    }

    public function newLoanAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $loan = new Loan($this->getUser());
        $form = $this->getLoanForm($loan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanChecker = $this->get(BankHandler::class)->userCanRequest($this->getUser(), $loan);
            if (true === $loanChecker[BankHandler::STATUS]) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($loan);
                $em->flush();
                $this->addFlash('success', sprintf('Votre demande pour un pret de %d$ a bien été remise au banquier, il vous tiendra au courant...', $loan->getAmount()));
                return $this->redirectToRoute('bank_index');
            }
            $this->addFlash('danger', sprintf('%s', $loanChecker[BankHandler::MESSAGE]));
        }

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
