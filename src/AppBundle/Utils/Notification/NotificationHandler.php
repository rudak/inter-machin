<?php

namespace AppBundle\Utils\Notification;

use AppBundle\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class NotificationHandler
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateStatus(array $notifications)
    {
        foreach ($notifications as $notification) {
            /** @var $notification Notification */
            $notification->setStatus(Notification::STATUS_READ);
            $this->em->persist($notification);
        }
        $this->em->flush();
    }
}