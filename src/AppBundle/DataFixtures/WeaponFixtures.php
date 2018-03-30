<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WeaponFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getWeaponsData() as $weaponData) {
            $weapon = new Weapon();
            $weapon->setName($weaponData['name']);
            $weapon->setAttack($weaponData['attack']);
            $weapon->setDefense($weaponData['defense']);
            $weapon->setPrice($weaponData['price']);
            $weapon->setUses($weaponData['uses']);
            $manager->persist($weapon);
        }
        $manager->flush();
    }

    private function getWeaponsData()
    {
        return [
            [
                'name'    => 'couteau suisse',
                'attack'  => 2,
                'defense' => 1,
                'price'   => 6,
                'uses'    => 5,
            ],
            [
                'name'    => 'batte',
                'attack'  => 6,
                'defense' => 2,
                'price'   => 12,
                'uses'    => 3,
            ],
            [
                'name'    => 'balais',
                'attack'  => 5,
                'defense' => 5,
                'price'   => 4,
                'uses'    => 5,
            ],
            [
                'name'    => 'matraque',
                'attack'  => 2,
                'defense' => 1,
                'price'   => 6,
                'uses'    => 5,
            ],
            [
                'name'    => 'planche',
                'attack'  => 2,
                'defense' => 10,
                'price'   => 3,
                'uses'    => 3,
            ],

            [
                'name'    => 'fourche a fumier',
                'attack'  => 15,
                'defense' => 4,
                'price'   => 12,
                'uses'    => 7,
            ],

            [
                'name'    => 'hache',
                'attack'  => 20,
                'defense' => 1,
                'price'   => 19,
                'uses'    => 8,
            ],
            [
                'name'    => '357 Magnum',
                'attack'  => 35,
                'defense' => 1,
                'price'   => 60,
                'uses'    => 7,
            ],
            [
                'name'    => 'Bazooka',
                'attack'  => 55,
                'defense' => 2,
                'price'   => 120,
                'uses'    => 1,
            ],
            [
                'name'    => 'grenade',
                'attack'  => 25,
                'defense' => 15,
                'price'   => 60,
                'uses'    => 1,
            ],
            [
                'name'    => 'bouclier',
                'attack'  => 1,
                'defense' => 18,
                'price'   => 15,
                'uses'    => 5,
            ],
            [
                'name'    => 'sac de sable',
                'attack'  => 4,
                'defense' => 22,
                'price'   => 6,
                'uses'    => 2,
            ],
            [
                'name'    => 'poing américain',
                'attack'  => 11,
                'defense' => 4,
                'price'   => 24,
                'uses'    => 5,
            ],
        ];
    }
}