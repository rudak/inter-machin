<?php
/**
 * Created by PhpStorm.
 * User: akadur
 * Date: 30/03/2018
 * Time: 18:16
 */

namespace AppBundle\Utils\Log;

use AppBundle\Entity\Log;
use UserBundle\Entity\User;

class LogCreator
{
    const TYPE_ITEM_SELL  = 'item_sell';
    const TYPE_ITEM_BUY   = 'item_buy';
    const TYPE_ITEM_THROW = 'item_throw';
    const TYPE_LUCK       = "luck";

    public static function getLog(User $user, $public, $text, $type)
    {
        return new Log($user,$public,$text,$type);
    }
}