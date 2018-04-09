<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Image\WeaponImage;
use AppBundle\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;

class WeaponFixtures extends Fixture
{

    const WEAPON_NAME    = 'weapon-name';
    const WEAPON_ATTACK  = 'weapon-attack';
    const WEAPON_DEFENSE = 'weapon-defense';
    const WEAPON_PRICE   = 'weapon-price';
    const WEAPON_USES    = 'weapon-uses';
    const WEAPON_LVL     = 'weapon-lvl';
    const IMG_PATH       = 'img-path';
    const IMG_NAME       = 'img-name';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getWeaponsData() as $weaponData) {
            $weapon = new Weapon();
            $weapon->setName($weaponData[self::WEAPON_NAME]);
            $weapon->setAttack($weaponData[self::WEAPON_ATTACK]);
            $weapon->setDefense($weaponData[self::WEAPON_DEFENSE]);
            $weapon->setPrice($weaponData[self::WEAPON_PRICE]);
            $weapon->setUses($weaponData[self::WEAPON_USES]);
            $weapon->setLvl($weaponData[self::WEAPON_LVL]);
            $weapon->setImage(
                $this->getImage($weaponData)
            );
            $manager->persist($weapon);
        }
        $manager->flush();
    }

    private function getImage(array $weaponData)
    {
        $image = new WeaponImage();
        $image->setName($weaponData[self::IMG_NAME]);
        $image->setPath($weaponData[self::IMG_PATH]);
        $this->copyRealImage($image);
        return $image;
    }

    private function copyRealImage(WeaponImage $image)
    {
        $fileSystem    = new Filesystem();
        $default_image = 'default_weapon.jpg';
        $pattern       = 'src/AppBundle/DataFixtures/Imgs/%s';
        $oldPath       = sprintf($pattern, $image->getPath());
        if (!$fileSystem->exists($oldPath)) {
            $oldPath = sprintf($pattern, $default_image);
        }
        $newPath = sprintf('web/%s/%s', WeaponImage::UPLOAD_DIR, $image->getPath());
        $fileSystem->copy($oldPath, $newPath, true);
    }

    private function getWeaponsData()
    {
        return [
            [
                self::WEAPON_NAME    => 'couteau suisse',
                self::WEAPON_ATTACK  => 2,
                self::WEAPON_DEFENSE => 1,
                self::WEAPON_PRICE   => 6,
                self::WEAPON_USES    => 5,
                self::WEAPON_LVL     => 1,
                self::IMG_PATH       => 'test_couteau_suisse.jpg',
                self::IMG_NAME       => 'couteau',
            ],
            [
                self::WEAPON_NAME    => 'batte',
                self::WEAPON_ATTACK  => 6,
                self::WEAPON_DEFENSE => 2,
                self::WEAPON_PRICE   => 12,
                self::WEAPON_USES    => 3,
                self::WEAPON_LVL     => 1,
                self::IMG_PATH       => 'test_batte.jpg',
                self::IMG_NAME       => 'batte',
            ],
            [
                self::WEAPON_NAME    => 'balais',
                self::WEAPON_ATTACK  => 5,
                self::WEAPON_DEFENSE => 5,
                self::WEAPON_PRICE   => 4,
                self::WEAPON_USES    => 5,
                self::WEAPON_LVL     => 1,
                self::IMG_PATH       => 'test_couteau_suisse.jpg',
                self::IMG_NAME       => 'balais',
            ],
            [
                self::WEAPON_NAME    => 'matraque',
                self::WEAPON_ATTACK  => 2,
                self::WEAPON_DEFENSE => 1,
                self::WEAPON_PRICE   => 6,
                self::WEAPON_USES    => 5,
                self::WEAPON_LVL     => 1,
                self::IMG_PATH       => 'test_matraque.jpg',
                self::IMG_NAME       => 'matraque',
            ],
            [
                self::WEAPON_NAME    => 'planche',
                self::WEAPON_ATTACK  => 2,
                self::WEAPON_DEFENSE => 10,
                self::WEAPON_PRICE   => 3,
                self::WEAPON_USES    => 3,
                self::WEAPON_LVL     => 1,
                self::IMG_PATH       => 'test_planche.jpg',
                self::IMG_NAME       => 'planche de bois',
            ],

            [
                self::WEAPON_NAME    => 'fourche a fumier',
                self::WEAPON_ATTACK  => 15,
                self::WEAPON_DEFENSE => 4,
                self::WEAPON_PRICE   => 12,
                self::WEAPON_USES    => 7,
                self::WEAPON_LVL     => 3,
                self::IMG_PATH       => 'test_fourche_fumier.jpg',
                self::IMG_NAME       => 'fourche',
            ],

            [
                self::WEAPON_NAME    => 'hache',
                self::WEAPON_ATTACK  => 20,
                self::WEAPON_DEFENSE => 1,
                self::WEAPON_PRICE   => 19,
                self::WEAPON_USES    => 8,
                self::WEAPON_LVL     => 5,
                self::IMG_PATH       => 'test_hache.jpg',
                self::IMG_NAME       => 'hache',
            ],
            [
                self::WEAPON_NAME    => '357 Magnum',
                self::WEAPON_ATTACK  => 35,
                self::WEAPON_DEFENSE => 1,
                self::WEAPON_PRICE   => 60,
                self::WEAPON_USES    => 7,
                self::WEAPON_LVL     => 12,
                self::IMG_PATH       => 'test_357.jpg',
                self::IMG_NAME       => '357 Magnum',
            ],
            [
                self::WEAPON_NAME    => 'Bazooka',
                self::WEAPON_ATTACK  => 55,
                self::WEAPON_DEFENSE => 2,
                self::WEAPON_PRICE   => 120,
                self::WEAPON_USES    => 1,
                self::WEAPON_LVL     => 15,
                self::IMG_PATH       => 'test_bazook.jpg',
                self::IMG_NAME       => 'Bazooka',
            ],
            [
                self::WEAPON_NAME    => 'grenade',
                self::WEAPON_ATTACK  => 25,
                self::WEAPON_DEFENSE => 15,
                self::WEAPON_PRICE   => 60,
                self::WEAPON_USES    => 1,
                self::WEAPON_LVL     => 7,
                self::IMG_PATH       => 'test_grenade.jpg',
                self::IMG_NAME       => 'grenade',
            ],
            [
                self::WEAPON_NAME    => 'bouclier',
                self::WEAPON_ATTACK  => 1,
                self::WEAPON_DEFENSE => 18,
                self::WEAPON_PRICE   => 15,
                self::WEAPON_USES    => 5,
                self::WEAPON_LVL     => 2,
                self::IMG_PATH       => 'test_bouclier.jpg',
                self::IMG_NAME       => 'bouclier',
            ],
            [
                self::WEAPON_NAME    => 'sac de sable',
                self::WEAPON_ATTACK  => 4,
                self::WEAPON_DEFENSE => 22,
                self::WEAPON_PRICE   => 6,
                self::WEAPON_USES    => 2,
                self::WEAPON_LVL     => 2,
                self::IMG_PATH       => 'test_sac_sable.jpg',
                self::IMG_NAME       => 'sac de sable',
            ],
            [
                self::WEAPON_NAME    => 'poing américain',
                self::WEAPON_ATTACK  => 11,
                self::WEAPON_DEFENSE => 4,
                self::WEAPON_PRICE   => 24,
                self::WEAPON_USES    => 5,
                self::WEAPON_LVL     => 2,
                self::IMG_PATH       => 'test_poing.jpg',
                self::IMG_NAME       => 'poing américain',
            ],
        ];
    }
}