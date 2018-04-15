<?php

namespace AppBundle\Entity\Action;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Church
 *
 * @ORM\Table(name="church")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChurchRepository")
 */
class Church
{

    const TYPE_PRAY          = 'pray';
    const TYPE_STEAL         = 'steal';
    const STATUS_SUCCESSFULL = 'successfull';
    const STATUS_FAILED      = 'failed';

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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=25)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",cascade={"persist"})
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="loot", type="smallint", nullable=true)
     */
    private $loot;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25)
     */
    private $type;

    public function __construct(User $user)
    {
        $this->user   = $user;
        $this->date   = new \DateTime();
        $this->status = self::STATUS_FAILED;
        $this->loot   = 0;
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
     * @return Church
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
     * @param string $status
     *
     * @return Church
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getLoot()
    {
        return $this->loot;
    }

    /**
     * @param int $loot
     */
    public function setLoot($loot)
    {
        $this->loot = $loot;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}

