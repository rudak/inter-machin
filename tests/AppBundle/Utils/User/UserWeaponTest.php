<?php

namespace Tests\AppBundle\Utils\User;

use AppBundle\Utils\User\UserWeapon;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Fake\FakeItem;
use Tests\AppBundle\Fake\FakeUser;

class UserWeaponTest extends KernelTestCase
{

    function testActivateItem()
    {
        $userWeapon = $this->getContainer()->get(UserWeapon::class);
        $user       = FakeUser::getObject(false, true, 1500, true);
        $item1      = FakeItem::getObject(false, true);
        $item2      = FakeItem::getObject(false, true);
        $item3      = FakeItem::getObject(false, true);
        $item4      = FakeItem::getObject(false, true);
        // on lui fait acheter 4 items
        $user->addItem($item1);
        $user->addItem($item2);
        $user->addItem($item3);
        $user->addItem($item4);
        // on ne peut en avoir qu'un au level 1
        $this->assertEquals(true, $userWeapon->activateItem($user, $item1), 'vous devriez pouvoir ajouter cet Item');
        $this->assertEquals(false, $userWeapon->activateItem($user, $item2), 'vous ne devriez pas pouvoir ajouter cet Item');
        // on peut en avoir 2 du level 5 au 9
        $user->getCompetences()->setLevel(5);
        $this->assertEquals(true, $userWeapon->activateItem($user, $item2), 'vous devriez pouvoir ajouter cet Item');
        $this->assertEquals(false, $userWeapon->activateItem($user, $item3), 'vous ne devriez pas pouvoir ajouter cet Item (2items max au niveau 5)');
        // on peut en avoir 3 a partir du level 10
        $user->getCompetences()->setLevel(10);
        $this->assertEquals(true, $userWeapon->activateItem($user, $item3), 'vous devriez pouvoir ajouter cet Item');
        $this->assertEquals(false, $userWeapon->activateItem($user, $item4), 'vous ne devriez pas pouvoir ajouter cet Item (3 items MAX peu importe le niveau)');
        // on le tue, ca vide les items
        $user->kill();
        $this->assertEquals(0, $user->getItems()->count(), 'Il est mort. il ne devrait plus avoir d\'items');
        $this->assertEquals(false, $userWeapon->activateItem($user, $item2), 'vous ne devriez pas pouvoir ajouter cet Item, il est mort');
        // on le remet en vie, ca le remet au level 1
        $user->setAlive(true);
        // on lui rachete deux items
        $user->addItem($item5 = FakeItem::getObject(false, true));
        $user->addItem($item6 = FakeItem::getObject(false, true));
        // on ne doit pouvoir en activer qu'un
        $this->assertEquals(true, $userWeapon->activateItem($user, $item5), 'vous devriez pouvoir ajouter cet Item');
        $this->assertEquals(false, $userWeapon->activateItem($user, $item6), 'vous ne devriez pas pouvoir ajouter cet Item');
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