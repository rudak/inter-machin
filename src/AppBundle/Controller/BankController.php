<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Action\Saving;
use AppBundle\Entity\Bank\Loan;
use AppBundle\Form\Bank\LoanRefundType;
use AppBundle\Form\Bank\LoanType;
use AppBundle\Form\Bank\SavingType;
use AppBundle\Services\Bank\BankHandler;
use AppBundle\Utils\Bank\LoansHanlder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BankController extends Controller
{

    public function indexAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $loans = $em->getRepository(Loan::class)->findAllLoansByUser($this->getUser());
        return $this->render(':bank:bank.html.twig', [
            'bankSaving'    => $this->getUser()->getSaving(),
            'activeLoans'   => LoansHanlder::loanFilter($loans, LoansHanlder::FILTER_ACTIVE_LOANS),
            'inactiveLoans' => LoansHanlder::loanFilter($loans, LoansHanlder::FILTER_INACTIVE_LOANS),
        ]);
    }

    public function newLoanAction(Request $request)
    {
        if (!$this->get(BankHandler::class)->maxLoansReached($this->getUser())) {
            return $this->redirectToRoute('bank_index');
        }

        $loan = new Loan($this->getUser());
        $form = $this->getLoanForm($loan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->get(BankHandler::class)->checkLoanAmount($loan)) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($loan);
            $em->flush();

            $this->addFlash('success', sprintf('Votre demande pour un pret de %d$ a bien été remise au banquier, il vous tiendra au courant...', $loan->getAmount()));

            return $this->redirectToRoute('bank_index');
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

    private function getLoanRefundForm(Loan $loan)
    {
        return $this->createForm(LoanRefundType::class, $loan, [
            'action' => $this->generateUrl('bank_loan_refund', [
                'id' => $loan->getId(),
            ]),
            'method' => 'POST',
        ]);
    }

    public function refundAction(Request $request, $id)
    {
        $em   = $this->getDoctrine()->getManager();
        $loan = $em->getRepository('AppBundle:Bank\Loan')->find($id);
        if (!$loan) {
            $this->addFlash('success', 'Cet emprunt est introuvable');
            return $this->redirectToRoute('bank_index');
        }
        $form = $this->getLoanRefundForm($loan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refundAmount = $form->get('money')->getData();
            if ($refundAmount > $loan->getUser()->getMoney()) {
                $this->addFlash('danger', 'Vous ne pouvez pas rembourser %d$, vous n\'avez que %d$ !', $refundAmount, $loan->getUser()->getMoney());
                return $this->redirectToRoute('bank_index');
            };

            $this->get(BankHandler::class)->refundLoan($loan, $refundAmount);

            $message = sprintf(
                "Vous remboursez %d$, il vous reste %d$ à payer avant le %s...",
                $refundAmount, $loan->getRestToPay(), $loan->getExpiration()->format('d/m/Y \\à H:i')
            );
            if (!$loan->getRestToPay()) {
                // si il ne reste rien a payer, on cloture
                $loan->setStatus(Loan::STATUS_CLOSED);
                $message = sprintf(
                    "Vous remboursez %d$, votre emprunt est maintenant cloturé, le banquier vous remercie.",
                    $refundAmount
                );
            }
            $this->addFlash('success', $message);
            $em->flush();
            return $this->redirectToRoute('bank_index');
        }

        return $this->render(':bank:loan_refund.html.twig', [
            'form' => $form->createView(),
            'loan' => $loan,
        ]);
    }

    public function cancelAction(Request $request, $id)
    {
        $submittedToken = $request->request->get('_csrf_token');
        if (!$this->isCsrfTokenValid('cancel_loan', $submittedToken)) {
            $this->addFlash('danger', 'Erreur du token');
            return $this->redirectToRoute('bank_index');
        }
        $em   = $this->getDoctrine()->getManager();
        $loan = $em->getRepository(Loan::class)->find($id);

        if (!$loan) {
            $this->addFlash('warning', 'Impossible de trouver ce pret.');
            return $this->redirectToRoute('bank_index');
        }

        if (!$loan->getStatus() == Loan::STATUS_REQUEST) {
            $this->addFlash('warning', sprintf("Désolé mais il n'est plus possible d'annuler ce pret de %d$. Bon courage...", $loan->getAmount()));
            return $this->redirectToRoute('bank_index');
        }

        $loan->setStatus(Loan::STATUS_CANCELED);
        $em->persist($loan);
        $em->flush();

        $this->addFlash('success', sprintf("Annulation de ce pret de %d$.", $loan->getAmount()));
        return $this->redirectToRoute('bank_index');
    }

    public function savingAction(Request $request)
    {
        $saving = new Saving($this->getUser());
        $form   = $this->getSavingForm($saving);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->getUser()->removeMoney($saving->getAmount());
            $this->getUser()->addSaving($saving->getAmount());
            $em->persist($saving);
            $em->flush();

            $this->addFlash('success', sprintf("Vous déposez %d$ sur votre compte d'épargne. Le banquier fera peut etre un geste...", $saving->getAmount()));

            return $this->redirectToRoute('bank_index');
        }
        return $this->render(':bank:saving.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function getSavingForm(Saving $saving)
    {
        return $this->createForm(SavingType::class, $saving, [
            'action' => $this->generateUrl('bank_saving'),
            'method' => 'POST',
        ]);
    }
}
