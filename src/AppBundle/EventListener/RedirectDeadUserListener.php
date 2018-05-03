<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\User;

class RedirectDeadUserListener
{
    const FORCE_ALIVE_PARAM = 'force-alive';

    private $tokenStorage;

    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, RouterInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->router       = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        if (!$this->isUserLogged()) {
            return;
        }
        if ($this->isUserExempted($event->getRequest())) {
            return;
        }
        if (!$this->isUserDead()) {
            return;
        }
        $currentRoute = $event->getRequest()->attributes->get('_route');

        if ($this->isTargetConcerned($currentRoute)) {
            return;
        }

        $response = new RedirectResponse($this->router->generate('dead_land'));
        $event->setResponse($response);
    }


    private function isUserLogged()
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return false;
        }
        $user = $token->getUser();
        return $user instanceof User;
    }

    private function isUserDead()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        return !$user->getAlive();
    }

    private function isUserExempted(Request $request)
    {
        if (!$request->query->has(self::FORCE_ALIVE_PARAM)) {
            return false;
        }
        $force = $request->query->get(self::FORCE_ALIVE_PARAM);

        if ($force == 1) {
            return true;
        }
        return false;
    }


    private function isTargetConcerned($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['fos_user_security_login', 'fos_user_resetting_request', 'app_user_registration', 'dead_land', 'rise_again']
        );
    }

}