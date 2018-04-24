<?php

namespace AppBundle\Utils\User;

use AppBundle\Entity\Item;
use AppBundle\Entity\Weapon;
use AppBundle\Utils\UtilsMaster;
use UserBundle\Entity\User;

class UserWeapon extends UtilsMaster
{
    const ERROR_KEY      = 'error';
    const ATTACK_POINTS  = 'attackPoints';
    const DEFENSE_POINTS = 'defensePoints';


    public function activateItem(User $user, Item $item)
    {
        if ($item->getActive()) {
            $this->session->getFlashBag()->add('warning', sprintf("L'objet %s est déja activé !", $item->getWeapon()->getName()));
            return false;
        }
        if (!$user->getAlive()) {
            $this->session->getFlashBag()->add('warning', sprintf("Mais! Vous etes morts !"));
            return false;
        }
        if ($this->getActivatedItemsNumber($user) >= $this->getAllowedItemsNumber($user)) {
            $this->session->getFlashBag()->add('danger', sprintf("Vous avez atteint le nombre d'items activés pour votre niveau ! (%d)", $this->getAllowedItemsNumber($user)));
            return false;
        }

        $item->setActive(true);
        $this->em->persist($item);
        $this->session->getFlashBag()->add('success', sprintf("Vous avez activé l'objet %s.", $item->getWeapon()->getName()));
        return true;
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
    private function getAllowedItemsNumber(User $user)
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
            if ($item->getWeapon() == $weapon) {
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
    private function getActivatedItemsNumber(User $user)
    {
        if (null == $user->getItems()) {
            return 0;
        }
        $number = 0;
        foreach ($user->getItems() as $userItem) {
            /** @var $userItem Item */
            $number += $userItem->getActive() ? 1 : 0;
        }
        return $number;
    }

    /**
     * Renvoie un tableau contenant la somme des points attack / defense en fonction des armes actives qu'il a.
     *
     * @param User $user
     * @return mixed
     */
    public static function getItemsAmountPointsForUser(User $user)
    {
        $attackPoints  = 0;
        $defensePoints = 0;
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if (!$item->getActive()) continue;
            $attackPoints  += $item->getWeapon()->getAttack();
            $defensePoints += $item->getWeapon()->getDefense();
        }
        return [
            self::ATTACK_POINTS  => $attackPoints > 100 ? 100 : $attackPoints,
            self::DEFENSE_POINTS => $defensePoints > 100 ? 100 : $defensePoints,
        ];
    }
}