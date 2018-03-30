<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Utils\Log\LogCreator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class StoreController extends Controller
{
    /**
     * lister les armes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $em      = $this->getDoctrine()->getManager();
        $weapons = $em->getRepository('AppBundle:Weapon')->findAll();

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
        $em     = $this->getDoctrine()->getManager();
        $weapon = $em->getRepository('AppBundle:Weapon')->find($id);

        return $this->render('store/weapon.html.twig', [
            'weapon' => $weapon,
        ]);
    }

    public function buyAction(Request $request, $id)
    {
        if (!$user = $this->getUser()) {
            $this->addFlash('danger', 'Vous devez etre authentifié pour accéder a cette page');
            return $this->redirectToRoute('homepage');
        }

        /** @var $user User */

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

        if ($weapon->getPrice() > $user->getMoney()) {
            $this->addFlash('danger', sprintf("%s coute %d$ mais vous n'avez que %d$...", $weapon->getName(), $weapon->getPrice(), $user->getMoney()));
            return $this->redirectToRoute('store_weapon', [
                'id' => $weapon->getId(),
            ]);
        }

        $item = new Item();
        $item->setActive(false);
        $item->setPrice($weapon->getPrice() / 2);
        $item->setUsages(0);
        $item->setUser($user);
        $item->setWeapon($weapon);

        $user->setMoney($user->getMoney() - $weapon->getPrice());

        $em->persist(LogCreator::getLog($user, true, sprintf("%s a acheté %s", $user->getUsername(), $item->getWeapon()->getName()), LogCreator::TYPE_ITEM_BUY));
        $em->persist($item);
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', sprintf("Vous venez d'acheter %s pour %d$. Il vous reste %d$.", $weapon->getName(), $weapon->getPrice(), $user->getMoney()));
        return $this->redirectToRoute('store_list');
    }

    public function sellAction(Request $request, $id)
    {
        if (!$user = $this->getUser()) {
            $this->addFlash('danger', 'Vous devez etre authentifié pour accéder a cette page');
            return $this->redirectToRoute('homepage');
        }
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
        
        $em->persist(LogCreator::getLog($user, true, sprintf("%s a vendu %s", $user->getUsername(), $item->getWeapon()->getName()), LogCreator::TYPE_ITEM_SELL));
        $user->setMoney($user->getMoney() + $item->getPrice());
        $user->removeItem($item);
        $em->remove($item);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('store_list');
    }
}
