<?php

namespace AppBundle\Entity\Action;

use AppBundle\Entity\Weapon;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Purchase
 *
 * @ORM\Table(name="action_purchase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\PurchaseRepository")
 */
class Purchase implements ActionInterface
{
    const ACTION_NAME = 'purchase';
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Weapon")
     */
    private $weapon;

    /**
     * Purchase constructor.
     * @param \DateTime $date
     * @param           $user
     * @param           $weapon
     */
    public function __construct(User $user, Weapon $weapon)
    {
        $this->date   = new \DateTime('NOW');
        $this->user   = $user;
        $this->weapon = $weapon;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Purchase
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return mixed
     */
    public function getWeapon()
    {
        return $this->weapon;
    }

    /**
     * @param mixed $weapon
     */
    public function setWeapon($weapon)
    {
        $this->weapon = $weapon;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getActionName()
    {
        return self::ACTION_NAME;
    }
}

