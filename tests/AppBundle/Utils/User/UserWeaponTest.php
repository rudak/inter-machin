<?php

namespace Tests\AppBundle\Utils\User;

use AppBundle\Entity\Item;
use AppBundle\Utils\User\UserItems;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Fake\FakeItem;
use Tests\AppBundle\Fake\FakeUser;

class UserWeaponTest extends KernelTestCase
{

    function testActivateItem()
    {

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