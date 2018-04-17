<?php

namespace AppBundle\Entity\Action;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Game
 *
 * @ORM\Table(name="action_game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\GameRepository")
 */
class Game implements ActionInterface
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",cascade={"persist"})
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
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="game", type="string", length=50)
     */
    private $game;

    /**
     * @var int
     *
     * @ORM\Column(name="gain", type="smallint", nullable=true)
     */
    private $gain;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="smallint", nullable=true)
     */
    private $amount;

    /**
     * Game constructor.
     * @param User      $user
     * @param \DateTime $date
     * @param bool      $status
     * @param string    $game
     * @param int       $gain
     */
    public function __construct(User $user, $status, $game, $amount = 0, $gain = 0)
    {
        $this->user   = $user;
        $this->date   = new \DateTime('NOW');
        $this->status = $status;
        $this->game   = $game;
        $this->gain   = $gain;
        $this->amount = $amount;
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
     * @param \stdClass $user
     *
     * @return Game
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
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
     * @return Game
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Game
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set game
     *
     * @param string $game
     *
     * @return Game
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set gain
     *
     * @param integer $gain
     *
     * @return Game
     */
    public function setGain($gain)
    {
        $this->gain = $gain;

        return $this;
    }

    /**
     * Get gain
     *
     * @return int
     */
    public function getGain()
    {
        return $this->gain;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }


}

