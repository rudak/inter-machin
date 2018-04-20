<?php

namespace AppBundle\Utils\User;

use AppBundle\Entity\Item;
use AppBundle\Entity\Weapon;
use UserBundle\Entity\User;

class UserWeapon
{
    const ERROR_KEY      = 'error';
    const ATTACK_POINTS  = 'attackPoints';
    const DEFENSE_POINTS = 'defensePoints';

    /**
     * selectionne l'item pour l'user (si il peut)
     *
     * @param User $user
     * @param Item $item
     * @return array|bool
     */
    public static function activateItem(User $user, Item $item)
    {
        if (self::getActivatedItemsNumber($user) < self::getAllowedItemsNumber($user)) {
            $item->setActive(true);
            return true;
        }
        if (self::getActivatedItemsNumber($user) == self::getAllowedItemsNumber($user)) {
            return [
                self::ERROR_KEY => sprintf('Vous avez atteint le nombre d\'armes activées maximum pour le niveau %d.', UserLevel::getLvl($user)),
            ];
        }
        return [
            self::ERROR_KEY => 'Ce n\'est pas possible, merci.',
        ];
    }

    /**
     * Repose un item
     *
     * @param Item $item
     */
    public static function deActivateItem(Item $item)
    {
        $item->setActive(false);
    }


    /**
     * Renvoie le nombre d'items actives que le gars peut avoir en fonction de son niveau
     *
     * @param User $user
     * @return int
     */
    public static function getAllowedItemsNumber(User $user)
    {
        $level = UserLevel::getLvl($user);
        if ($level == 1) {
            return 1;
        } elseif ($level >= 5 && $level < 10) {
            return 2;
        } else {
            return 3;
        }
    }


    /**
     * Verifie si l'user a déja cette arme
     * @param User   $user
     * @param Weapon $weapon
     * @return bool
     */
    public static function isWeaponAlreadyPossessed(User $user, Weapon $weapon)
    {
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if ($item->getWeapon()->getId() == $weapon->getId()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Renvoie le nombre d'objet actifs que le gars possède
     *
     * @param User $user
     * @return int
     */
    private static function getActivatedItemsNumber(User $user)
    {
        $number = 0;
        foreach ($user->getItems() as $userItem) {
            /** @var $userItem Item */
            $number += $userItem->getActive() ? 1 : 0;
        }
        return $number;
    }

    /**
     * Renvoie un tableau contenant ses points attack / defense en fonction des armes actives qu'il a.
     * @param User $user
     * @return mixed
     */
    public static function getItemsAmountPointsForUser(User $user)
    {
        $points [self::ATTACK_POINTS]  = 0;
        $points [self::DEFENSE_POINTS] = 0;
        $items                         = $user->getItems();
        foreach ($items as $item) {
            /** @var $item Item */
            if (!$item->getActive()) continue;
            $points[self::ATTACK_POINTS]  += $item->getWeapon()->getAttack();
            $points[self::DEFENSE_POINTS] += $item->getWeapon()->getDefense();
        }
        $points[self::ATTACK_POINTS]  = $points[self::ATTACK_POINTS] > 100 ? 100 : $points[self::ATTACK_POINTS];
        $points[self::DEFENSE_POINTS] = $points[self::DEFENSE_POINTS] > 100 ? 100 : $points[self::DEFENSE_POINTS];
        return $points;
    }

}