<?php

namespace Tests\AppBundle\Services\Action\City;

use AppBundle\Services\Action\City\CityHandler;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\Fake\FakeCity;
use Tests\AppBundle\Fake\FakeUser;

class CityHandlerTest extends KernelTestCase
{
    public function testMove()
    {
        $user     = FakeUser::getObject(false, true, 1500);
        $richCity = FakeCity::getObject('richCity', 99999, true);
        $poorCity = FakeCity::getObject('poorCity', 900, true);

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