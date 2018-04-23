<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Utils\User\UserWeapon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends Controller
{

    /**
     * L'utilisateur active un objet se trouvant dans son sac
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getAction($id)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em   = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);
        if (!$item) {
            $this->addFlash('danger', 'Cet objet n\'est plus disponible.');
            return $this->redirectToRoute('homepage');
        }

        $this->get(UserWeapon::class)->activateItem($this->getUser(), $item);

        $em->flush();
        return $this->redirectToRoute('myProfile');
    }

    /**
     * L'user repose un objet dans son sac
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function putAction($id)
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');
        $em   = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);
        if (!$item) {
            $this->addFlash('danger', 'Cet objet n\'est plus disponible.');
            return $this->redirectToRoute('homepage');
        }
        UserWeapon::deActivateItem($item);
        $this->addFlash('success', sprintf("Vous venez de poser %s.", $item->getWeapon()->getName()));

        $em->persist($item);
        $em->flush();

        return $this->redirectToRoute('myProfile');
    }

    /**
     * L'user se débarrasse d'un objet
     *
     * @param Request $request
     * @param         $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function throwAction(Request $request, $id)
    {
        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('item_throw', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas jeter cet objet, token incorrect.');
            return $this->redirectToRoute('homepage');
        }

        $em   = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);
        if (!$item) {
            $this->addFlash('danger', 'Cet objet n\'est plus disponible.');
            return $this->redirectToRoute('homepage');
        }

        //            TODO: Transformer en 'action'
//        $em->persist(LogCreator::getLog($this->getUser(), false, sprintf("%s a jeté %s", $this->getUser()->getUsername(), $item->getWeapon()->getName()), LogCreator::TYPE_ITEM_THROW));

        $this->addFlash('success', sprintf('Vous avez jeté : %s.', $item->getWeapon()->getName()));
        $em->remove($item);
        $em->flush();

        return $this->redirectToRoute('myProfile');

    }
}
