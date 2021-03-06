<?php

namespace AppBundle\Services\Command;

use AppBundle\Entity\Action\Saving;
use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Notification;
use AppBundle\Utils\AppConfig;
use AppBundle\Utils\Bank\FriendlyVisit;
use AppBundle\Utils\Bank\Interests;
use AppBundle\Utils\Bank\ReminderHandler;
use AppBundle\Utils\Notification\NotificationCreator;
use AppBundle\Utils\User\UserLevel;
use UserBundle\Entity\User;

class Banker extends CronEmCommand
{

    public function answeringRequestedLoan()
    {
        $loans = $this->em->getRepository(Loan::class)->findBy(['status' => Loan::STATUS_REQUEST]);
        foreach ($loans as $loan) {
            if (rand(0, 100) > AppConfig::BANKER_VALIDATION_PERCENTAGE) {
                continue;
            }
            $loan->setStatus(Loan::STATUS_VALID);
            $loan->setExpiration(new \DateTime('+5 days'));
            $percentage  = mt_rand(1, UserLevel::getLvl($loan->getUser()) * 2);
            $percentage  = $percentage > AppConfig::LOAN_MAX_PERCENTAGE ? AppConfig::LOAN_MAX_PERCENTAGE : $percentage;
            $tax         = round($percentage * $loan->getAmount() / 100);
            $taxedAmount = $loan->getAmount() - $tax;
            $loan->setPercentage($percentage);
            $loan->getUser()->addMoney($taxedAmount);
            $message = sprintf(
                "Votre pret de %d$ avec un taux à %d%% a bien été accepté, %d$ sont arrivés sur votre compte. (A rembourser avant le %s).",
                $loan->getAmount(),
                $loan->getPercentage(),
                $taxedAmount,
                $loan->getDate()->format('d/m/Y')
            );
            $this->em->persist(
                NotificationCreator::getNotification($loan->getUser(), $message, Notification::TYPE_LOAN_VALIDATION));
//            TODO: Transformer en 'action'
//            $this->em->persist(
//                LogCreator::getLog($loan->getUser(), false, $message, LogCreator::TYPE_BANKER));
            $this->em->persist($loan);
        }
        $this->em->flush();
    }

    public function reminderLoan()
    {
        $loans = $this->em->getRepository(Loan::class)->findBy(['status' => Loan::STATUS_VALID]);
        foreach ($loans as $loan) {
            ReminderHandler::loanReminder($loan, $this->em);
        }
        $this->em->flush();
    }

    public function friendlyVisit()
    {
        $loans = $this->em->getRepository(Loan::class)->findBy(['status' => Loan::STATUS_LATE]);
        foreach ($loans as $loan) {
            FriendlyVisit::visit($loan, $this->em);
        }
        $this->em->flush();
    }

    public function savingInterests()
    {
        $users = $this->em->getRepository(User::class)->getUsersWithSavedMoney();
        foreach ($users as $user) {
            if (rand(1, 1000) < 995) continue;
            Interests::execute($user, $this->em);
        }
        $this->em->flush();
    }


}