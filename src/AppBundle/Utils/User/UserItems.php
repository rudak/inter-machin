<?php

namespace AppBundle\Utils\User;

use AppBundle\Entity\Item;
use UserBundle\Entity\User;

class UserItems
{
    const ACTIVE   = 'active';
    const INACTIVE = 'inactive';

    /**
     * Renvoie une chaine avec le nom des armes
     *
     * @param User $user
     * @return string
     */
    public static function getActiveItemsNames(User $user)
    {
        $names = [];
        foreach (self::getActiveItems($user) as $item) {
            /** @var $item Item */
            $names[] = $item->getWeapon()->getName();
        }
        return count($names) ? implode(' et ', $names) : 'vos mains';
    }

    /**
     * Vire les items qui ont assez servi
     * @param User $user
     * @return \Generator
     */
    public static function updateItemsUses(User $user)
    {
        foreach (self::getActiveItems($user) as $item) {
            /** @var $item Item */
            $item->setUsages($item->getUsages() + 1);
            if ($item->getUsages() >= $item->getWeapon()->getUses()) {
                yield $item;
                $user->removeItem($item);
            }
        }
    }

    /**
     * Renvoie un generator contenant les itemps actifs
     * @param User $user
     * @return \Generator
     */
    public static function getActiveItems(User $user)
    {
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if (!$item->getActive()) {
                continue;
            }
            yield $item;
        }
    }

    /**
     * Renvoie un tableau d'items avec deux indexes, ACTIVE ou INACTIVE
     * @param User $user
     * @return array
     */
    public static function getSortedItems(User $user)
    {
        $activeItems   = [];
        $inactiveItems = [];
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if ($item->getActive()) {
                $activeItems[] = $item;
                continue;
            }
            $inactiveItems[] = $item;
        }
        return [
            self::ACTIVE   => $activeItems,
            self::INACTIVE => $inactiveItems,
        ];
    }
}