<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Action\Purchase;
use AppBundle\Entity\Item;
use AppBundle\Utils\User\UserLevel;
use AppBundle\Utils\User\UserWeapon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class StoreController extends Controller
{
    /**
     * lister les armes
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder à cette page !');
        $em      = $this->getDoctrine()->getManager();
        $weapons = $em->getRepository('AppBundle:Weapon')->getWeaponByLevel($this->getUser());

        return $this->render('store/list.html.twig', [
            'weapons'    => $weapons,
            'user_items' => $this->getUser()->getItems(),
        ]);
    }

    /**
     * voir une arme
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function weaponAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder à cette page !');
        $em     = $this->getDoctrine()->getManager();
        $weapon = $em->getRepository('AppBundle:Weapon')->find($id);

        return $this->render('store/weapon.html.twig', [
            'weapon' => $weapon,
        ]);
    }

    public function buyAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        /** @var $user User */
        $user = $this->getUser();

        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('weapon_buy', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas acheter cet objet, token incorrect.');
            return $this->redirectToRoute('homepage');
        }
        $em     = $this->getDoctrine()->getManager();
        $weapon = $em->getRepository('AppBundle:Weapon')->find($id);

        if (!$weapon) {
            $this->addFlash('danger', 'Cet objet n\'est pas disponible.');
            return $this->redirectToRoute('store_list');
        }

        if ($weapon->getLvl() > UserLevel::getLvl($user)) {
            $this->addFlash('danger', sprintf("Pour acheter '%s' vous devez etre au niveau %d ou plus.", $weapon->getName(), $weapon->getLvl()));
            return $this->redirectToRoute('store_list');
        }

        if (UserWeapon::isWeaponAlreadyPossessed($user, $weapon)) {
            $this->addFlash('danger', sprintf("Vous possedez déja %s...", $weapon->getName()));
            return $this->redirectToRoute('store_list');
            return $this->redirectToRoute('store_weapon', [
                'id' => $weapon->getId(),
            ]);
        }

        if ($weapon->getPrice() > $user->getMoney()) {
            $this->addFlash('danger', sprintf("%s coute %d$ mais vous n'avez que %d$...", $weapon->getName(), $weapon->getPrice(), $user->getMoney()));
            return $this->redirectToRoute('store_list');
            return $this->redirectToRoute('store_weapon', [
                'id' => $weapon->getId(),
            ]);
        }

        $item = new Item();
        $item->setActive(false);
        $item->setPrice(rand($weapon->getPrice() / 2, $weapon->getPrice()));
        $item->setUsages(0);
        $item->setUser($user);
        $item->setWeapon($weapon);

        $user->removeMoney($weapon->getPrice());

        //            TODO: Transformer en 'action'
//        $em->persist(LogCreator::getLog($user, true, sprintf("%s a acheté %s", $user->getUsername(), $item->getWeapon()->getName()), LogCreator::TYPE_ITEM_BUY));
        $em->persist(new Purchase($user, $weapon));
        $em->persist($item);
        $em->flush();

        $this->addFlash('success', sprintf("Vous venez d'acheter '%s' pour %d$. Il vous reste %d$.", $weapon->getName(), $weapon->getPrice(), $user->getMoney()));
        return $this->redirectToRoute('store_list');
    }

    public function sellAction(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous devez etre authentifié pour accéder a cette page !');

        $user = $this->getUser();
        /** @var $user User */

        $submittedToken = $request->request->get('_csrf_token');

        if (!$this->isCsrfTokenValid('item_sell', $submittedToken)) {
            $this->addFlash('danger', 'Vous ne pouvez pas vendre cet objet, token incorrect.');
            return $this->redirectToRoute('homepage');
        }

        $em   = $this->getDoctrine()->getManager();
        $item = $em->getRepository('AppBundle:Item')->find($id);

        if (!$item) {
            $this->addFlash('danger', "Cet objet n'est plus disponible.");

            return $this->redirectToRoute('store_list');
        }

        $this->addFlash('success', sprintf("Vous venez de vendre %s pour %d$. Merci.", $item->getWeapon()->getName(), $item->getPrice()));

        //            TODO: Transformer en 'action'
//        $em->persist(LogCreator::getLog($user, true, sprintf("%s a vendu %s", $user->getUsername(), $item->getWeapon()->getName()), LogCreator::TYPE_ITEM_SELL));
        $user->setMoney($user->getMoney() + $item->getPrice());
        $user->removeItem($item);
        $em->remove($item);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('store_list');
    }
}
