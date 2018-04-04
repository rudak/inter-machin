<?php

namespace AppBundle\Utils\Bank;

use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Notification;
use Doctrine\ORM\EntityManager;

class ReminderHandler
{
    public static function loanReminder(Loan $loan, EntityManager $em)
    {
        $now = new \DateTime('NOW');
        if ($loan->getExpiration() > $now) {
            self::simpleDailyRemind($loan, $now, $em);
            return;
        }
        self::retardedRemind($loan, $em);
    }

    private static function simpleDailyRemind(Loan $loan, \Datetime $now, EntityManager $em)
    {
        $daysLeft = $now->diff($loan->getExpiration())->format('%a');

        $message = sprintf(
            "Plus que %d jour pour rembourser votre pret de %d$. Sinon...",
            $daysLeft,
            $loan->getAmount() - $loan->getRefunded()
        );
        $em->persist(
            NotificationCreator::getNotification(
                $loan->getUser(),
                $message,
                Notification::TYPE_LOAN_REMINDER
            )
        );
    }

    private static function retardedRemind(Loan $loan, EntityManager $em)
    {
        $loan->setStatus(Loan::STATUS_LATE);
        $em->persist($loan);
        $em->persist(
            NotificationCreator::getNotification(
                $loan->getUser(),
                "Vous avez dépassé la date d'expiration de votre pret ! Le banquier va s'occuper de vous !",
                Notification::TYPE_LOAN_REMINDER
            )
        );
    }
}