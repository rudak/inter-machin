<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RenderController extends Controller
{

    public function getLogsAction()
    {
        $em   = $this->getDoctrine()->getManager();
        $logs = $em->getRepository('AppBundle:Log')->getLogs($this->getUser());

        return $this->render('render/logs.html.twig', [
            'logs' => $logs,
        ]);
    }
}
