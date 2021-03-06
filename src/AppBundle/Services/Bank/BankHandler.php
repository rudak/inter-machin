<?php

namespace AppBundle\Services\Bank;

use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Bank\Refund;
use AppBundle\Utils\AppConfig;
use AppBundle\Utils\Bank\LoansHanlder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class BankHandler
{
    const STATUS  = 'status';
    const MESSAGE = 'message';

    protected $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    /**
     * Verifie si l'user a moins de prets actifs que le max autorisé
     * @param User $user
     * @return bool
     */
    public function maxLoansReached(User $user)
    {
        $userLoans   = $this->em->getRepository(Loan::class)->findAllLoansByUser($user);
        $activeLoans = LoansHanlder::loanFilter($userLoans, LoansHanlder::FILTER_ACTIVE_LOANS);
        if (count($activeLoans) < AppConfig::MAX_ACTIVE_LOANS_ALLOWED) {
            return true;
        }
        $this->session->getFlashBag()->add('danger', sprintf("Demande refusée. Vous ne pouvez avoir que %d emprunts actifs.", AppConfig::MAX_ACTIVE_LOANS_ALLOWED));
        return false;
    }

    /**
     * Verifie si l'emprunt s'eleve a moins d'un tiers du total de l'utilisateur
     *
     * @param Loan $loan
     * @return bool
     */
    public function checkLoanAmount(Loan $loan)
    {
        $third = round($loan->getUser()->getMoney() / 3);
        if ($loan->getAmount() <= $third) {
            return true;
        }
        $this->session->getFlashBag()->add('danger', sprintf("Demande refusée. Vous ne pouvez pas demander plus de %d$ au banquier.", $third));
        return false;
    }

    /**
     * Paye un remboursement de pret
     *
     * @param Loan   $loan
     * @param        $refundAmount
     * @param string $type
     * @return Refund
     */
    public function refundLoan(Loan $loan, $refundAmount, $type = Refund::TYPE_USER)
    {
        $loan->setRefunded($loan->getRefunded() + $refundAmount);
        $loan->getUser()->removeMoney($refundAmount);
        $this->em->persist(new Refund($loan, $refundAmount, $type));
    }

}