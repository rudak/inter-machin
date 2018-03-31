<?php

namespace UserBundle\Entity;

use AppBundle\Entity\Competences;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Competences",cascade={"persist"})
     */
    private $competences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $alive;

    /**
     * @ORM\Column(name="money", type="smallint")
     */
    private $money;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Item",mappedBy="user")
     */
    private $items;


    public function __construct()
    {
        parent::__construct();
        $this->alive       = true;
        $this->money       = 20;
        $this->competences = new Competences();
    }

    /**
     * Set alive
     *
     * @param boolean $alive
     *
     * @return User
     */
    public function setAlive($alive)
    {
        $this->alive = $alive;

        return $this;
    }

    /**
     * Get alive
     *
     * @return boolean
     */
    public function getAlive()
    {
        return $this->alive;
    }

    /**
     * Set money
     *
     * @param integer $money
     *
     * @return User
     */
    public function setMoney($money)
    {
        $this->money = $money < 0 ? 0 : $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return integer
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set competences
     *
     * @param Competences $competences
     *
     * @return User
     */
    public function setCompetences(Competences $competences = null)
    {
        $this->competences = $competences;

        return $this;
    }

    /**
     * Get competences
     *
     * @return Competences
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Item $item
     *
     * @return User
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Item $item
     */
    public function removeItem(\AppBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
