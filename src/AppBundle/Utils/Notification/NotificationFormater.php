<?php

namespace AppBundle\Utils\Notification;

use AppBundle\Entity\Notification;

class NotificationFormater
{
    public static function formatNotifications(array $notifications)
    {
        $out = [];
        foreach ($notifications as $notification) {
            $out[] = self::formatNotification($notification);
        }
        return $out;
    }

    private static function formatNotification(Notification $notification)
    {
        return [
            'date'    => $notification->getDate()->format('U'),
            'message' => $notification->getMessage(),
            'title'   => self::getNotificationTitle($notification->getType()),
            'id'      => $notification->getId(),
        ];
    }

    private static function getNotificationTitle($type)
    {
        switch ($type) {
            case Notification::TYPE_LOAN_VALIDATION:
                return 'Le banquier';
                break;
            default:
                return 'Information';
        }
    }
}