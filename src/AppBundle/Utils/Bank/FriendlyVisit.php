<?php

namespace AppBundle\Utils\Bank;

use AppBundle\Entity\Bank\Loan;
use AppBundle\Entity\Notification;
use AppBundle\Utils\Notification\NotificationCreator;
use Doctrine\ORM\EntityManager;

class FriendlyVisit
{
    const TAX = 'tax';

    public static function visit(Loan $loan, EntityManager $em)
    {
        if (rand(0, 1)) {
            self::taxTheDude($loan, $em);
        } else {
            self::kickTheDude($loan, $em);
        }
        $em->persist($loan);
        $em->flush();
    }

    /**
     * Le banquier prend des tunes au type mais si il reste des dettes il repassera...
     * Si il a pas de tunes il le tape un peu pour la route.
     *
     * @param Loan          $loan
     * @param EntityManager $em
     */
    private static function taxTheDude(Loan $loan, EntityManager $em)
    {
        if (!$loan->getUser()->getMoney()) {
            self::kickTheDude($loan, $em);
            return;
        }
        #TODO: taxer le gars
    }

    /**
     * Le banquier tabasse un peu le type, et reviendra forcement...
     *
     * @param Loan          $loan
     * @param EntityManager $em
     */
    private static function kickTheDude(Loan $loan, EntityManager $em)
    {
        #TODO: tabasser le gars
    }
}