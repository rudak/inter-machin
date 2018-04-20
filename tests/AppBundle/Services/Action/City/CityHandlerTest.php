<?php

namespace Tests\AppBundle\Services\Action\City;

use AppBundle\Services\Action\City\CityHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\CityHelper;
use Tests\AppBundle\Services\UserHelper;
use UserBundle\Entity\User;

class CityHandlerTest extends KernelTestCase
{
    public function testMove()
    {
        $user     = UserHelper::getFakeUser(false, true, 1500);
        $richCity = CityHelper::getFakeCity('richCity', 99999, true);
        $poorCity = CityHelper::getFakeCity('poorCity', 900, true);

        $kernel = static::createKernel();
        $kernel->boot();
        $container       = $kernel->getContainer();
        $realCityHandler = $container->get(CityHandler::class);

        $this->assertEquals(false, $realCityHandler->move($user, $richCity), 'On devrait pas pouvoir acheter cette ville');
        $this->assertEquals(true, $realCityHandler->move($user, $poorCity), 'Cette ville devrait etre abordable');
        $this->assertEquals(false, $realCityHandler->move($user, $poorCity), 'Il est fauché il ne devrait pas pouvoir changer de ville cette fois');
        $this->assertEquals(600, $user->getMoney(), 'Il devrait rester 600 balles a l\'user');
    }
}