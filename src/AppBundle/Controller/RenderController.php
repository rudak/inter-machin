<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RenderController extends Controller
{

    public function getLogsAction()
    {
        if (!$this->getUser()) {
            return new Response();
        }
        $em   = $this->getDoctrine()->getManager();

        return $this->render('render/logs.html.twig', [
            'logs' => [],
        ]);
    }
}
