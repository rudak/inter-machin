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
        $activeItems = self::getActiveItems($user);
        return implode(' et ', $activeItems);
    }



    private static function getActiveItems(User $user)
    {
        $out = [];
        foreach ($user->getItems() as $item) {
            /** @var $item Item */
            if (!$item->getActive()) {
                continue;
            }
            $out[] = $item->getWeapon()->getName();
        }
        return $out;
    }


}