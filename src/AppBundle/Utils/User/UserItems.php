<?php

namespace AppBundle\Utils\User;

use AppBundle\Entity\Item;
use UserBundle\Entity\User;

class UserItems
{
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
        return implode(' et ', $names);
    }


    private static function getActiveItems(User $user)
    {
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if (!$item->getActive()) {
                continue;
            }
            yield $item;
        }
    }


}