<?php

namespace AppBundle\Entity\Action;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Steal
 *
 * @ORM\Table(name="action_steal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\StealRepository")
 */
class Steal
{
    const STATUS_SUCCESSFULL   = 'successfull';
    const STATUS_FAILED        = 'failed';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",cascade={"persist"})
     */
    private $burglar;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",cascade={"persist"})
     */
    private $victim;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="loot", type="smallint", nullable=true)
     */
    private $loot;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=25)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="victim_damage", type="smallint")
     */
    private $victimDamage;

    /**
     * @var int
     *
     * @ORM\Column(name="burglar_damage", type="smallint")
     */
    private $burglarDamage;

    /**
     * @var int
     *
     * @ORM\Column(name="burglar_skill", type="smallint", nullable=true)
     */
    private $burglarSkill;

    /**
     * Steal constructor.
     * @param           $burglar
     * @param           $victim
     * @param \DateTime $date
     */
    public function __construct(User $victim, User $burglar)
    {
        $this->victim        = $victim;
        $this->burglar       = $burglar;
        $this->date          = new \DateTime();
        $this->status        = self::STATUS_FAILED;
        $this->loot          = 0;
        $this->victimDamage  = 0;
        $this->burglarDamage = 0;
        $this->burglarSkill  = 0;
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
     * Set burglar
     *
     * @param \stdClass $burglar
     *
     * @return Steal
     */
    public function setBurglar($burglar)
    {
        $this->burglar = $burglar;

        return $this;
    }

    /**
     * Get burglar
     *
     * @return \stdClass
     */
    public function getBurglar()
    {
        return $this->burglar;
    }

    /**
     * Set victim
     *
     * @return Steal
     */
    public function setVictim($victim)
    {
        $this->victim = $victim;

        return $this;
    }

    /**
     * Get victim
     *
     * @return \stdClass
     */
    public function getVictim()
    {
        return $this->victim;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Steal
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
     * Set loot
     *
     * @param integer $loot
     *
     * @return Steal
     */
    public function setLoot($loot)
    {
        $this->loot = $loot;

        return $this;
    }

    /**
     * Get loot
     *
     * @return int
     */
    public function getLoot()
    {
        return $this->loot;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Steal
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
     * Set victimDamage
     *
     * @param integer $victimDamage
     *
     * @return Steal
     */
    public function setVictimDamage($victimDamage)
    {
        $this->victimDamage = $victimDamage;

        return $this;
    }

    /**
     * Get victimDamage
     *
     * @return int
     */
    public function getVictimDamage()
    {
        return $this->victimDamage;
    }

    /**
     * Set burglarDamage
     *
     * @param integer $burglarDamage
     *
     * @return Steal
     */
    public function setBurglarDamage($burglarDamage)
    {
        $this->burglarDamage = $burglarDamage;

        return $this;
    }

    /**
     * Get burglarDamage
     *
     * @return int
     */
    public function getBurglarDamage()
    {
        return $this->burglarDamage;
    }

    /**
     * Set burglarSkill
     *
     * @param integer $burglarSkill
     *
     * @return Steal
     */
    public function setBurglarSkill($burglarSkill)
    {
        $this->burglarSkill = $burglarSkill;

        return $this;
    }

    /**
     * Get burglarSkill
     *
     * @return int
     */
    public function getBurglarSkill()
    {
        return $this->burglarSkill;
    }
}

