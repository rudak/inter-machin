<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",inversedBy="items",cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Weapon")
     */
    private $weapon;

    /**
     * @var int
     *
     * @ORM\Column(name="usages", type="smallint")
     */
    private $usages;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="smallint")
     */
    private $price;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * Item constructor.
     */
    public function __construct()
    {
        $this->usages = 0;
        $this->price  = 0;
        $this->active = 0;
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
     * Set usages
     *
     * @param integer $usages
     *
     * @return Item
     */
    public function setUsages($usages)
    {
        $this->usages = $usages;

        return $this;
    }

    /**
     * Get usages
     *
     * @return integer
     */
    public function getUsages()
    {
        return $this->usages;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Item
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set weapon
     *
     * @param \AppBundle\Entity\Weapon $weapon
     *
     * @return Item
     */
    public function setWeapon(\AppBundle\Entity\Weapon $weapon = null)
    {
        $this->weapon = $weapon;

        return $this;
    }

    /**
     * Get weapon
     *
     * @return \AppBundle\Entity\Weapon
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Item
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Item
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
}
