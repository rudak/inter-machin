<?php

namespace AppBundle\Entity\Action;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Alive
 *
 * @ORM\Table(name="action_alive")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\AliveRepository")
 */
class Alive implements ActionInterface
{
    const ACTION_NAME = 'alive';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean", nullable=true)
     */
    private $state;

    /**
     * Alive constructor.
     * @param User $user
     * @param bool $state
     */
    public function __construct(User $user, $state = true)
    {
        $this->user  = $user;
        $this->state = $state;
        $this->date  = new \DateTime('NOW');
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
     * Set user
     *
     * @param User $user
     *
     * @return Alive
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Alive
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
     * Set state
     *
     * @param boolean $state
     *
     * @return Alive
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    public function getActionName()
    {
        return self::ACTION_NAME;
    }
}

