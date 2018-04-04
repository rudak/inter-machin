<?php

namespace AppBundle\Services\Command;

use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Notification;
use AppBundle\Utils\AppConfig;
use AppBundle\Utils\Log\LogCreator;
use AppBundle\Utils\Notification\NotificationCreator;

class Banker extends CronEmCommand
{


    public function execute()
    {
        $this->answeringRequestedLoan();
    }

    private function answeringRequestedLoan()
    {
        $loans = $this->em->getRepository(Loan::class)->findBy(['status' => Loan::STATUS_REQUEST]);
        foreach ($loans as $loan) {
            if (rand(0, 100) > AppConfig::BANKER_VALIDATION_PERCENTAGE) {
                continue;
            }
            $loan->setStatus(Loan::STATUS_VALID);
            $loan->setExpiration(new \DateTime('+5 days'));
            $loan->getUser()->addMoney($loan->getAmount());
            $this->em->persist(
                NotificationCreator::getNotification(
                    $loan->getUser(),
                    sprintf("Votre pret de %d$ a été accepté. Il devra être remboursé avant le %s. Merci a vous.", $loan->getAmount(), $loan->getDate()->format('d/m/Y')),
                    Notification::TYPE_LOAN_VALIDATION)
            );
            $this->em->persist(
                LogCreator::getLog(
                    $loan->getUser(),
                    false,
                    sprintf("Votre pret de %d$ a été accepté. Il devra être remboursé avant le %s. Merci a vous.", $loan->getAmount(), $loan->getDate()->format('d/m/Y')),
                    LogCreator::TYPE_BANKER)
            );
            $this->em->persist($loan);
        }
        $this->em->flush();
    }


}