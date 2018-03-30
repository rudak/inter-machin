<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapon
 *
 * @ORM\Table(name="weapon")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeaponRepository")
 */
class Weapon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="attack", type="smallint")
     */
    private $attack;

    /**
     * @var int
     *
     * @ORM\Column(name="defense", type="smallint")
     */
    private $defense;


    /**
     * @var int
     *
     * @ORM\Column(name="price", type="smallint")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="uses", type="smallint")
     */
    private $uses;

    /**
     * Weapon constructor.
     */
    public function __construct()
    {
        $this->attack  = 0;
        $this->defense = 0;
        $this->price   = 0;
        $this->uses    = 0;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Weapon
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     *
     * @return Weapon
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;

        return $this;
    }

    /**
     * Get attack
     *
     * @return integer
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     *
     * @return Weapon
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return integer
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Weapon
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set uses
     *
     * @param integer $uses
     *
     * @return Weapon
     */
    public function setUses($uses)
    {
        $this->uses = $uses;

        return $this;
    }

    /**
     * Get uses
     *
     * @return integer
     */
    public function getUses()
    {
        return $this->uses;
    }
}
