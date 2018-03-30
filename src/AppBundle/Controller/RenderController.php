<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RenderController extends Controller
{

    public function getLogsAction()
    {
        if ($this->getUser()) {
            $em   = $this->getDoctrine()->getManager();
            $logs = $em->getRepository('AppBundle:Log')->getLogs($this->getUser());

            return $this->render('render/logs.html.twig', [
                'logs' => $logs,
            ]);
        }
        $response = new Response();
        return $response;
    }
}
