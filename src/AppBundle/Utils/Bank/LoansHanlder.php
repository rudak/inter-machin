<?php

namespace AppBundle\Utils\Bank;

use AppBundle\Entity\Bank\Loan;
use Symfony\Component\Config\Definition\Exception\Exception;

class LoansHanlder
{
    const FILTER_ACTIVE_LOANS   = 'active';
    const FILTER_INACTIVE_LOANS = 'inactive';

    public static function loanFilter(array $loans, $filter)
    {
        if (!in_array($filter, [self::FILTER_ACTIVE_LOANS, self::FILTER_INACTIVE_LOANS])) {
            throw new Exception(sprintf("Le filtre '%s' est inconnu.", $filter));
        }
        return array_filter($loans, [__CLASS__, $filter]);
    }


    private static function active(Loan $loan)
    {
        return in_array($loan->getStatus(), [
            Loan::STATUS_REQUEST,
            Loan::STATUS_VALID,
            Loan::STATUS_LATE,
        ]);
    }

    private static function inactive(Loan $loan)
    {
        return in_array($loan->getStatus(), [
            Loan::STATUS_CANCELED,
            Loan::STATUS_CLOSED,
            Loan::STATUS_REFUSED,
        ]);
    }
}