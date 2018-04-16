<?php

namespace AppBundle\Controller;

use AppBundle\Services\Action\User\AttackHandler;
use AppBundle\Services\Action\User\StealHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActionController extends Controller
{
    public function stealAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        $em = $this->getDoctrine()->getManager();

        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('action_steal', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas voler ce type, token incorrect.');
            return $this->redirectToRoute('homepage');
        }

        if (!$victim = $em->getRepository('UserBundle:User')->find($id)) {
            $this->addFlash('danger', "Cet user n'existe pas");
            return $this->redirectToRoute('user_list');
        }

        $this->get(StealHandler::class)->execute($victim, $this->getUser());

        return $this->render(':default:user.html.twig', [
            'user' => $victim,
        ]);

    }

    public function attackAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em = $this->getDoctrine()->getManager();

        if (!$victim = $em->getRepository('UserBundle:User')->find($id)) {
            $this->addFlash('danger', "Cet user n'existe pas");
            return $this->redirectToRoute('user_list');
        }
        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('action_attack', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas attaquer ce type, token incorrect.');
            return $this->redirectToRoute('homepage');
        }

        $this->get(AttackHandler::class)->execute($victim, $this->getUser());

        if(!$victim->getAlive()){
            return $this->redirectToRoute('user_list');
        }

        return $this->render(':default:user.html.twig', [
            'user' => $victim,
        ]);
    }


}
