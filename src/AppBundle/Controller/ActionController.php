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

        if (!$user = $em->getRepository('UserBundle:User')->find($id)) {
            $this->addFlash('danger', "Cet user n'existe pas");
            return $this->redirectToRoute('user_list');
        }

        $stealResult = $this->get(StealHandler::class)->execute($user, $this->getUser());
        $stealEntity = $stealResult[StealHandler::INDEX_ENTITY];

        $em->persist($stealResult[StealHandler::INDEX_LOG_VICTIM]);
        $em->persist($stealResult[StealHandler::INDEX_LOG_BURGLAR]);
        $em->persist($stealEntity);
        $em->flush();

        $this->addFlash($stealEntity->getStatus() == Steal::STATUS_SUCCESSFULL ? 'success' : 'danger', $stealResult[StealHandler::INDEX_MESSAGE]);

        return $this->render(':default:user.html.twig', [
            'user' => $user,
        ]);

    }


}
