<?php

namespace AppBundle\Utils\Notification;

use AppBundle\Entity\Notification;
use UserBundle\Entity\User;

class NotificationCreator
{
    public static function getNotification(User $user, $message, $type)
    {
        return new Notification($user, $message, $type);
    }
}