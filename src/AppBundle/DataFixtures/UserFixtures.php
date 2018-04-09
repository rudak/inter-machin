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
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserssData() as $key => $userData) {
            $user = new User();
            if ('admin' == $userData['username']) {
                $user->setMoney(999);
                $user->getCompetences()->setLevel(10);
            }
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setDateOfBirth($this->getRandomDateTime());
            $user->setEnabled(true);
            if (isset($userData['level'])) {
                $user->getCompetences()->setLevel($userData['level']);
            }
            $password = $this->encoder->encodePassword($user, $userData['plainPassword']);
            $user->setPassword($password);
            $user->setCity($this->getReference(CityFixtures::FIRST_CITY));
            $manager->persist($this->createStartAccount($user));
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function createStartAccount(User $user)
    {
        return (new Account())->hydratAccount($user)->setDate(New \DateTime('0 hour'));
    }

    private function getUserssData()
    {
        return [
            [
                'username'      => 'admin',
                'plainPassword' => 'admin',
                'email'         => 'admin@free.fr',
                'roles'         => ['ROLE_SUPER_ADMIN'],
            ],
            [
                'username'      => 'joe',
                'plainPassword' => '0000',
                'email'         => 'joe@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => rand(1, 15),
            ],
            [
                'username'      => 'mitch',
                'plainPassword' => '0000',
                'email'         => 'mitch@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => 12,
            ],
            [
                'username'      => 'eric',
                'plainPassword' => '0000',
                'email'         => 'eric@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => rand(1, 15),
            ],
            [
                'username'      => 'caroline',
                'plainPassword' => '0000',
                'email'         => 'caroline@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => rand(1, 15),
            ],
            [
                'username'      => 'sophie',
                'plainPassword' => '0000',
                'email'         => 'sophie@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => 12,
            ],
            [
                'username'      => 'bryan',
                'plainPassword' => '0000',
                'email'         => 'bryan@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => 4,
            ],
            [
                'username'      => 'philippe',
                'plainPassword' => '0000',
                'email'         => 'phil@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => rand(1, 15),
            ],
            [
                'username'      => 'eddy',
                'plainPassword' => '0000',
                'email'         => 'eddy@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => rand(1, 15),
            ],
            [
                'username'      => 'raoul',
                'plainPassword' => '0000',
                'email'         => 'raoul@free.fr',
                'roles'         => ['ROLE_USER'],
                'level'         => 17,
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