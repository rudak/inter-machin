<?php

namespace AppBundle\Utils\Bank;

use AppBundle\Entity\Action\Saving;
use AppBundle\Utils\AppConfig;
use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;

class Interests
{
    public static function execute(User $user, EntityManager $em)
    {
        $amount = self::getInterestAmount($user);
        $user->addSaving($amount);
        $em->persist($user);
        $em->persist(self::addAction($user, $amount));
    }

    /**
     * Détermine le montant de l'interet
     * @param User $user
     * @return float|int
     */
    private static function getInterestAmount(User $user)
    {
        $interest = round($user->getSaving() / 100);
        $interest = $interest > AppConfig::BANKER_MAX_INTERESTS
            ? AppConfig::BANKER_MAX_INTERESTS
            : $interest < AppConfig::BANKER_MIN_INTERESTS
                ? AppConfig::BANKER_MIN_INTERESTS
                : $interest;
        return $interest;
    }

    private static function addAction(User $user, $amount)
    {
        $saving = new Saving($user, Saving::TYPE_BANKER);
        return $saving->setAmount($amount);

    }

}