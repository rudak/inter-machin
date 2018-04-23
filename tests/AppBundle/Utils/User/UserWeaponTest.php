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
        $user = FakeUser::getObject(false, true, 1500);

//        $user->addItem(FakeItem::getObject(true, true));

        $result = UserWeapon::activateItem($user, FakeItem::getObject(false, true));
        dump($result);
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