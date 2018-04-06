<?php

namespace AppBundle\Utils\Bank;

use AppBundle\Entity\Bank\Loan;

class LoansHanlder
{
    public static function filterActiveLoans(array $loans)
    {
        $activeLoans = [];
        foreach ($loans as $loan) {
            /** @var $loan Loan */
            if (in_array($loan->getStatus(), [Loan::STATUS_REQUEST, Loan::STATUS_LATE, Loan::STATUS_VALID])) {
                $activeLoans[] = $loan;
            }
        }
        return $activeLoans;
    }

    public static function filterInactiveLoans(array $loans)
    {
        $inactiveLoans = [];
        foreach ($loans as $loan) {
            /** @var $loan Loan */
            if (in_array($loan->getStatus(), [Loan::STATUS_CANCELED, Loan::STATUS_CLOSED, Loan::STATUS_REFUSED])) {
                $inactiveLoans[] = $loan;
            }
        }
        return $inactiveLoans;
    }
}