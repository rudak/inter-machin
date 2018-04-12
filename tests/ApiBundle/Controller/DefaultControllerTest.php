<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{
    public function testBankDataAction()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', '/api/bank/my-account-data.json');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testBankUsersAccountsAction()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', '/api/bank/users-accounts.json');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testGame_oneTenDataAction()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', '/api/game/one-ten-data.json');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testPurchaseDataAction()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', '/api/store/purchase-data.json');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testUserMoneyDataAction()
    {
        $client = $this->createAuthorizedClient();
        $client->request('GET', '/api/bank/users-money-data.json');
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    protected function createAuthorizedClient()
    {
        $client    = static::createClient();
        $container = static::$kernel->getContainer();
        $session   = $container->get('session');
        $person    = self::$kernel->getContainer()->get('doctrine')->getRepository(User::class)->findOneByUsername('admin');

        $token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }
}