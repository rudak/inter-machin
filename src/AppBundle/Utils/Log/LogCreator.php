<?php

namespace AppBundle\Utils\Log;

use AppBundle\Entity\Log;
use UserBundle\Entity\User;

class LogCreator
{
    const TYPE_ITEM_SELL  = 'item_sell';
    const TYPE_ITEM_BUY   = 'item_buy';
    const TYPE_ITEM_THROW = 'item_throw';
    const TYPE_LUCK       = "luck";
    const TYPE_NO_LUCK    = "no-luck";
    const TYPE_STEAL      = 'steal';
    const TYPE_BANKER     = 'banker-loan-validation';

    public static function getLog(User $user, $public, $text, $type)
    {
        return new Log($user, $public, $text, $type);
    }
}