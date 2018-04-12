<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;

class DefaultControllerTest extends WebTestCase
{


    public function testLoginRedirect()
    {
        $client = static::createClient();
        $urls   = ['/store/list', '/ranking', '/cities', '/bank/', '/game/', '/user/my-profile', '/store/weapon/157'];
        foreach ($urls as $url) {
            $client->request('GET', $url);
            $this->assertEquals(302, $client->getResponse()->getStatusCode(), sprintf("L'url '%s' devrait renvoyer un code 302", $url));
            $this->assertRegExp('/\/login$/', $client->getResponse()->headers->get('location'), sprintf("L'url '%s' ne redirige pas vers le login.", $url));
        }
    }

    public function testIndex()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Accueil")')->count()
        );
    }

    public function testLogin()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Authentification")')->count()
        );
    }

    public function testStore()
    {
        $client  = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/store/list');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Magasin")')->count()
        );
    }

    public function testWeapon()
    {
        $client  = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/store/weapon/157');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Magasin")')->count()
        );
    }

    public function testClassement()
    {
        $client  = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/ranking');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Classement")')->count()
        );
    }

    public function testVilles()
    {
        $client  = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/cities');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Les villes")')->count()
        );
    }

    public function testBank()
    {
        $client  = $this->createAuthorizedClient();
        $crawler = $client->request('GET', '/bank/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Banque")')->count()
        );
    }

    public function testGame()
    {
        $client = $this->createAuthorizedClient();

        $crawler = $client->request('GET', '/game/');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("GameLand")')->count()
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