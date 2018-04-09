<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Image\WeaponImage;
use AppBundle\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class WeaponFixtures extends Fixture
{

    const IMG_NAME = 'img_name';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getWeaponsData() as $weaponData) {
            $weapon = new Weapon();
            $weapon->setName($weaponData['name']);
            $weapon->setAttack($weaponData['attack']);
            $weapon->setDefense($weaponData['defense']);
            $weapon->setPrice($weaponData['price']);
            $weapon->setUses($weaponData['uses']);
            $weapon->setLvl($weaponData['lvl']);
            $weapon->setImage(
                $this->getImage($weaponData[self::IMG_NAME])
            );
            $manager->persist($weapon);
        }
        $manager->flush();
    }

    private function getImage($name)
    {
        $image = new WeaponImage();
        $image->setName('default weapon image');
        $image->setPath($name);
        $this->copyRealImage($image);
        return $image;
    }

    private function copyRealImage(WeaponImage $image)
    {
        $fileSystem = new Filesystem();
        $oldPath    = 'src/AppBundle/DataFixtures/Imgs/default_weapon.jpg';
        $newPath    = sprintf('web/imgs/weapon/%s', $image->getPath());
        $fileSystem->copy($oldPath, $newPath, true);
    }

    private function getWeaponsData()
    {
        return [
            [
                'name'         => 'couteau suisse',
                'attack'       => 2,
                'defense'      => 1,
                'price'        => 6,
                'uses'         => 5,
                'lvl'          => 1,
                self::IMG_NAME => 'test_couteau_suisse.jpg',
            ],
            [
                'name'         => 'batte',
                'attack'       => 6,
                'defense'      => 2,
                'price'        => 12,
                'uses'         => 3,
                'lvl'          => 1,
                self::IMG_NAME => 'test_batte.jpg',
            ],
            [
                'name'         => 'balais',
                'attack'       => 5,
                'defense'      => 5,
                'price'        => 4,
                'uses'         => 5,
                'lvl'          => 1,
                self::IMG_NAME => 'test_couteau_suisse.jpg',
            ],
            [
                'name'         => 'matraque',
                'attack'       => 2,
                'defense'      => 1,
                'price'        => 6,
                'uses'         => 5,
                'lvl'          => 1,
                self::IMG_NAME => 'test_matraque.jpg',
            ],
            [
                'name'         => 'planche',
                'attack'       => 2,
                'defense'      => 10,
                'price'        => 3,
                'uses'         => 3,
                'lvl'          => 1,
                self::IMG_NAME => 'test_planche.jpg',
            ],

            [
                'name'         => 'fourche a fumier',
                'attack'       => 15,
                'defense'      => 4,
                'price'        => 12,
                'uses'         => 7,
                'lvl'          => 3,
                self::IMG_NAME => 'test_fourche_fumier.jpg',
            ],

            [
                'name'         => 'hache',
                'attack'       => 20,
                'defense'      => 1,
                'price'        => 19,
                'uses'         => 8,
                'lvl'          => 5,
                self::IMG_NAME => 'test_hache.jpg',
            ],
            [
                'name'         => '357 Magnum',
                'attack'       => 35,
                'defense'      => 1,
                'price'        => 60,
                'uses'         => 7,
                'lvl'          => 12,
                self::IMG_NAME => 'test_357.jpg',
            ],
            [
                'name'         => 'Bazooka',
                'attack'       => 55,
                'defense'      => 2,
                'price'        => 120,
                'uses'         => 1,
                'lvl'          => 15,
                self::IMG_NAME => 'test_bazook.jpg',
            ],
            [
                'name'         => 'grenade',
                'attack'       => 25,
                'defense'      => 15,
                'price'        => 60,
                'uses'         => 1,
                'lvl'          => 7,
                self::IMG_NAME => 'test_grenade.jpg',
            ],
            [
                'name'         => 'bouclier',
                'attack'       => 1,
                'defense'      => 18,
                'price'        => 15,
                'uses'         => 5,
                'lvl'          => 2,
                self::IMG_NAME => 'test_bouclier.jpg',
            ],
            [
                'name'         => 'sac de sable',
                'attack'       => 4,
                'defense'      => 22,
                'price'        => 6,
                'uses'         => 2,
                'lvl'          => 2,
                self::IMG_NAME => 'test_sac_sable.jpg',
            ],
            [
                'name'         => 'poing américain',
                'attack'       => 11,
                'defense'      => 4,
                'price'        => 24,
                'uses'         => 5,
                'lvl'          => 2,
                self::IMG_NAME => 'test_poing.jpg',
            ],
        ];
    }
}