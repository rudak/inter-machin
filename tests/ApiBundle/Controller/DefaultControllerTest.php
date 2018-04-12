<?php

namespace Tests\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{

    private $client;

    public function testApiReturnsJson()
    {
        $client = $this->createAuthorizedClient();
        $urls   = [
            '/api/bank/my-account-data.json', '/api/bank/users-accounts.json', '/api/game/one-ten-data.json',
            '/api/store/purchase-data.json', '/api/bank/users-money-data.json',
        ];
        foreach ($urls as $url) {
            $client->request('GET', $url);
            $this->assertTrue(
                $client->getResponse()->headers->contains('Content-Type', 'application/json'),
                sprintf("L'url %s doit renvoyer du JSON !", $url)
            );
        }
    }

    protected function createAuthorizedClient()
    {
        if (null == $this->client) {
            $client    = static::createClient();
            $container = static::$kernel->getContainer();
            $session   = $container->get('session');
            $person    = self::$kernel->getContainer()->get('doctrine')->getRepository(User::class)->findOneByUsername('admin');

            $token = new UsernamePasswordToken($person, null, 'main', $person->getRoles());
            $session->set('_security_main', serialize($token));
            $session->save();

            $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));
            $this->client = $client;
        }

        return $client;
    }
}