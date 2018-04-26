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
        $amount = round($user->getSaving() / 100);
        return $amount >= AppConfig::BANKER_MIN_INTERESTS ? $amount : AppConfig::BANKER_MIN_INTERESTS;
    }

    private static function addAction(User $user, $amount)
    {
        $saving = new Saving($user, Saving::TYPE_BANKER);
        return $saving->setAmount($amount);

    }

}