<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Bank\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\User;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    const INDEX_USERNAME      = 'username';
    const INDEX_PLAINPASSWORD = 'plainPassword';
    const INDEX_EMAIL         = 'email';
    const INDEX_ROLES         = 'roles';
    const INDEX_LEVEL         = 'level';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserssData() as $key => $userData) {
            $user = new User();
            if ('admin' == $userData[self::INDEX_USERNAME]) {
                $user->setMoney(999);
                $user->getCompetences()->setLevel(10);
            }
            $user->setUsername($userData[self::INDEX_USERNAME]);
            $user->setEmail($userData[self::INDEX_EMAIL]);
            $user->setRoles($userData[self::INDEX_ROLES]);
            $user->setDateOfBirth($this->getRandomDateTime());
            $user->setEnabled(true);
            if (isset($userData[self::INDEX_LEVEL])) {
                $user->getCompetences()->setLevel($userData[self::INDEX_LEVEL]);
            }
            $password = $this->encoder->encodePassword($user, $userData[self::INDEX_PLAINPASSWORD]);
            $user->setPassword($password);
            $user->setCity($this->getReference(CityFixtures::FIRST_CITY));
            $manager->persist($this->createStartAccount($user));
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function createStartAccount(User $user)
    {
        return (new Account())->hydratAccount($user)->setDate(New \DateTime('today midnight'));
    }

    private function getUserssData()
    {
        return [
            [
                self::INDEX_USERNAME      => 'admin',
                self::INDEX_PLAINPASSWORD => 'admin',
                self::INDEX_EMAIL         => 'admin@free.fr',
                self::INDEX_ROLES         => ['ROLE_SUPER_ADMIN'],
            ],
            [
                self::INDEX_USERNAME      => 'joe',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'joe@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => rand(1, 15),
            ],
            [
                self::INDEX_USERNAME      => 'mitch',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'mitch@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => 12,
            ],
            [
                self::INDEX_USERNAME      => 'eric',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'eric@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => rand(1, 15),
            ],
            [
                self::INDEX_USERNAME      => 'caroline',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'caroline@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => rand(1, 15),
            ],
            [
                self::INDEX_USERNAME      => 'sophie',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'sophie@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => 12,
            ],
            [
                self::INDEX_USERNAME      => 'bryan',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'bryan@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => 4,
            ],
            [
                self::INDEX_USERNAME      => 'philippe',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'phil@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => rand(1, 15),
            ],
            [
                self::INDEX_USERNAME      => 'eddy',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'eddy@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => rand(1, 15),
            ],
            [
                self::INDEX_USERNAME      => 'raoul',
                self::INDEX_PLAINPASSWORD => '0000',
                self::INDEX_EMAIL         => 'raoul@free.fr',
                self::INDEX_ROLES         => ['ROLE_USER'],
                self::INDEX_LEVEL         => 17,
            ],
        ];
    }

    private function getRandomDateTime()
    {
        $int    = mt_rand(time() - (60 * 60 * 24 * 60), time());
        $format = "Y-m-d H:i:s";
        return \DateTime::createFromFormat($format, date($format, $int));
    }

    public function getDependencies()
    {
        return [
            CityFixtures::class,
        ];
    }
}