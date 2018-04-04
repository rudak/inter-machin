<?php

namespace AppBundle\Services\Bank;

use AppBundle\Entity\Bank\Loan;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class BankHandler
{
    const STATUS  = 'status';
    const MESSAGE = 'message';

    protected $em;

    protected $message;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function userCanRequest(User $user, Loan $loan)
    {
        if (!$this->checkCurrentLoans($user)) {
            return [
                self::STATUS  => false,
                self::MESSAGE => $this->message,
            ];
        }
        if (!$this->checkLoan($user, $loan)) {
            return [
                self::STATUS  => false,
                self::MESSAGE => $this->message,
            ];
        }
        return [self::STATUS => true];
    }

    private function checkCurrentLoans(User $user)
    {
        $currentLoans = $this->em->getRepository(Loan::class)->getLoansForUser($user);

        if (count($currentLoans) >= 3) {
            $this->message = 'Vous avez déja 3 prets en cours, régularisez votre situation.';
            return false;
        }
        return true;
    }

    private function checkLoan(User $user, Loan $loan)
    {
        $third = round($user->getMoney() / 3);
        if ($loan->getAmount() > $third) {
            $this->message = sprintf('Vous ne pouvez pas demander un pret plus d\'un tiers de votre solde total (max %d$).', $third);
            return false;
        }
        return true;
    }

}