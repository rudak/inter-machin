<?php

namespace AppBundle\Utils\User;

use AppBundle\Entity\Item;
use Doctrine\ORM\EntityManager;
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
        return count($names) ? implode(' et ', $names) : 'vos mains';
    }

    public static function updateItemsUses(User $user, EntityManager $em)
    {
//        Todo: Revoir la neccessité de passer $em pour virer le $item
        foreach (self::getActiveItems($user) as $item) {
            /** @var $item Item */
            $item->setUsages($item->getUsages() + 1);
            if ($item->getUsages() >= $item->getWeapon()->getUses()) {
                $user->removeItem($item);
                $em->remove($item);
            }
        }
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