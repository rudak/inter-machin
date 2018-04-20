<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Action\ActionHandler;
use AppBundle\Utils\Action\HtmlFormater;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class RenderController extends Controller
{

    public function getActionsAction()
    {
        if (!$this->getUser()) {
            return new Response();
        }
        $cache      = new FilesystemAdapter();
        $actionLogs = $cache->getItem('render.action.logs');
        if (!$actionLogs->isHit()) {
            $dateFrom = new \DateTime('-1 week');
            $actions  = $this->get(ActionHandler::class)->getActions($this->getUser(), $dateFrom);
            $html     = $this->get(HtmlFormater::class)->getHtmlForActions($this->getUser(), $actions);
            $actionLogs->set($html)->expiresAfter(15);
            $cache->save($actionLogs);
        }
        $html = $actionLogs->get();

        return $this->render('render/actions.html.twig', [
            'html' => $html,
        ]);
    }
}
