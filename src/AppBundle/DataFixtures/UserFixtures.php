<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\User;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserssData() as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setEnabled(true);
            $password = $this->encoder->encodePassword($user, $userData['plainPassword']);
            $user->setPassword($password);

            $manager->persist($user);
        }
        $manager->flush();
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
            ],
            [
                'username'      => 'mitch',
                'plainPassword' => '0000',
                'email'         => 'mitch@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'eric',
                'plainPassword' => '0000',
                'email'         => 'eric@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'caroline',
                'plainPassword' => '0000',
                'email'         => 'caroline@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'sophie',
                'plainPassword' => '0000',
                'email'         => 'sophie@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'bryan',
                'plainPassword' => '0000',
                'email'         => 'bryan@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'philippe',
                'plainPassword' => '0000',
                'email'         => 'phil@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'eddy',
                'plainPassword' => '0000',
                'email'         => 'eddy@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
            [
                'username'      => 'raoul',
                'plainPassword' => '0000',
                'email'         => 'raoul@free.fr',
                'roles'         => ['ROLE_USER'],
            ],
        ];
    }
}