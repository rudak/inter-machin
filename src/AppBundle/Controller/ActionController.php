<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Action\Steal;
use AppBundle\Services\Action\StealHandler;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActionController extends Controller
{
    public function stealAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        $em = $this->getDoctrine()->getManager();

        if (!$victim = $em->getRepository('UserBundle:User')->find($id)) {
            $this->addFlash('danger', "Cet user n'existe pas");
            return $this->redirectToRoute('user_list');
        }

        $this->get(StealHandler::class)->execute($victim, $this->getUser());

        return $this->render(':default:user.html.twig', [
            'user' => $victim,
        ]);

    }


}
