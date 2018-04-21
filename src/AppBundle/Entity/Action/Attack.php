<?php

namespace AppBundle\Entity\Action;

use AppBundle\Entity\Item;
use AppBundle\Services\Action\User\AttackHandler;
use AppBundle\Utils\User\UserItems;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Attack
 *
 * @ORM\Table(name="action_attack")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\AttackRepository")
 */
class Attack implements ActionInterface
{
    const ACTION_NAME = 'attack';

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
    private $attacker;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $victim;

    /**
     * @var bool
     *
     * @ORM\Column(name="Killed", type="boolean", nullable=true)
     */
    private $killed;

    /**
     * @var int
     *
     * @ORM\Column(name="damages", type="smallint", nullable=true)
     */
    private $damages;

    /**
     * @var int
     *
     * @ORM\Column(name="skill", type="smallint", nullable=true)
     */
    private $skill;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Weapon")
     */
    private $weapons;


    /**
     * Constructor
     */
    public function __construct(User $attacker, User $victim, $damage = 0, $skill = 0, $killed = false)
    {
        $this->weapons  = new ArrayCollection();
        $this->attacker = $attacker;
        $this->victim   = $victim;
        $this->damages  = $damage;
        $this->skill    = $skill;
        $this->killed   = $killed;
        $this->date     = new \DateTime('NOW');
        $this->amount   = 0;
        foreach (UserItems::getActiveItems($attacker) as $item) {
            /** @var $item Item */
            $this->weapons->add($item->getWeapon());
        }
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
     * Set killed
     *
     * @param boolean $killed
     *
     * @return Attack
     */
    public function setKilled($killed)
    {
        $this->killed = $killed;

        return $this;
    }

    /**
     * Get killed
     *
     * @return boolean
     */
    public function getKilled()
    {
        return $this->killed;
    }

    /**
     * Set damages
     *
     * @param integer $damages
     *
     * @return Attack
     */
    public function setDamages($damages)
    {
        $this->damages = $damages;

        return $this;
    }

    /**
     * Get damages
     *
     * @return integer
     */
    public function getDamages()
    {
        return $this->damages;
    }

    /**
     * Set skill
     *
     * @param integer $skill
     *
     * @return Attack
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return integer
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Attack
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
     * Set attacker
     *
     * @param User $attacker
     *
     * @return Attack
     */
    public function setAttacker(User $attacker = null)
    {
        $this->attacker = $attacker;

        return $this;
    }

    /**
     * Get attacker
     *
     * @return User
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * Set victim
     *
     * @param User $victim
     *
     * @return Attack
     */
    public function setVictim(User $victim = null)
    {
        $this->victim = $victim;

        return $this;
    }

    /**
     * Get victim
     *
     * @return User
     */
    public function getVictim()
    {
        return $this->victim;
    }

    /**
     * Add weapon
     *
     * @param \AppBundle\Entity\Weapon $weapon
     *
     * @return Attack
     */
    public function addWeapon(\AppBundle\Entity\Weapon $weapon)
    {
        $this->weapons[] = $weapon;

        return $this;
    }

    /**
     * Remove weapon
     *
     * @param \AppBundle\Entity\Weapon $weapon
     */
    public function removeWeapon(\AppBundle\Entity\Weapon $weapon)
    {
        $this->weapons->removeElement($weapon);
    }

    /**
     * Get weapons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWeapons()
    {
        return $this->weapons;
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


    public function getActionName()
    {
        return self::ACTION_NAME;
    }
}
