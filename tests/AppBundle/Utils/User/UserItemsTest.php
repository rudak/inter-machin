<?php

namespace Tests\AppBundle\Utils\User;

use AppBundle\Entity\Item;
use AppBundle\Utils\User\UserItems;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Fake\FakeItem;
use Tests\AppBundle\Fake\FakeUser;

class UserItemsTest extends KernelTestCase
{
    public function testUserItems()
    {
        $user = FakeUser::getObject(false, true, 1500);

        $user->addItem(FakeItem::getObject(true, true));
        $user->addItem(FakeItem::getObject(true, true));
        $user->addItem(FakeItem::getObject(true, true));
        $user->addItem(FakeItem::getObject(false, true));
        $user->addItem(FakeItem::getObject(false, true));

        // les objets, triés
        $sortedItems = UserItems::getSortedItems($user);
        $this->assertArrayHasKey(UserItems::ACTIVE, $sortedItems, 'Il manque la clé active');
        $this->assertArrayHasKey(UserItems::INACTIVE, $sortedItems, 'Il manque la clé inactive');
        $this->assertEquals(3, count($sortedItems[UserItems::ACTIVE]), 'Il devrait y avoir 3 items active');
        $this->assertEquals(2, count($sortedItems[UserItems::INACTIVE]), 'Il devrait y avoir 3 items inactive');

        // les objets actifs
        $activeItems = UserItems::getActiveItems($user);
        $this->assertInstanceOf(\Generator::class, $activeItems, 'Ca devrait etre un generateur .');
        $this->assertInstanceOf(Item::class, $activeItems->current(), 'Ca devrait etre un Item .');

        // vérification du jetage d'objets qui ont assez servi
        $itemThrowed = UserItems::updateItemsUses($user);
        $this->assertEquals(null, $itemThrowed->current(), 'Il ne doit rien avoir dans ce generateur car aucun objet ne devrait etre utilisé assez de fois');
        $itemThrowedAgain = UserItems::updateItemsUses($user);
        $this->assertInstanceOf(Item::class, $itemThrowedAgain->current(), 'On devrait avoir un item vu qu\'il doit etre jeté a ce moment la.');
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        return $kernel->getContainer();
    }
}