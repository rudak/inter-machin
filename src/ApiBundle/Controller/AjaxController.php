<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Notification;
use AppBundle\Utils\Notification\NotificationFormater;
use AppBundle\Utils\Notification\NotificationHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller
{
    public function notificationsAction()
    {
        if (!$this->getUser()) {
            return $this->getNoAuthenticatedErrorResponse();
        }
        $em            = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository(Notification::class)->getUserNotificationByStatus(Notification::STATUS_WAIT, $this->getUser());
        $this->get(NotificationHandler::class)->updateStatus($notifications);
        return new JsonResponse([
            'status'        => true,
            'notifications' => NotificationFormater::formatNotifications($notifications),
        ]);
    }

    private function getNoAuthenticatedErrorResponse()
    {
        return new JsonResponse([
            'status' => false,
            'error'  => "No Authenticated",
        ], 200);
    }
}
