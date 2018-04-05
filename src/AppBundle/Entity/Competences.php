<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competences
 *
 * @ORM\Table(name="competences")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompetencesRepository")
 */
class Competences
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
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="life", type="smallint")
     */
    private $life;

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
     * @ORM\Column(name="skill", type="smallint")
     */
    private $skill;

    /**
     * Competences constructor.
     * @param int $level
     */
    public function __construct()
    {
        $this->level   = 1;
        $this->attack  = 10;
        $this->defense = 10;
        $this->life    = 30;
        $this->skill   = 10;
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
     * Set level
     *
     * @param integer $level
     *
     * @return Competences
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set life
     *
     * @param integer $life
     *
     * @return Competences
     */
    public function setLife($life)
    {
        $this->life = $life;

        return $this;
    }

    /**
     * Get life
     *
     * @return integer
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     *
     * @return Competences
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
     * @return Competences
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
     * @return int
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param int $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    public function addAttackPoints($amount)
    {
        $this->attack += $amount;
        if ($this->attack > 100) {
            $this->attack = 100;
        }

        return $this;
    }

    public function addLifePoints($amount)
    {
        $this->life += $amount;
        if ($this->life > 100) {
            $this->life = 100;
        }

        return $this;
    }

    public function removeLifePoints($amount)
    {
        $this->life -= $amount;
        if ($this->life < 0) {
            $this->life = 0;
        }

        return $this;
    }

    public function addDefensePoints($amount)
    {
        $this->defense += $amount;
        if ($this->defense > 100) {
            $this->defense = 100;
        }

        return $this;
    }


    public function removeAttackPoints($amount)
    {
        $this->attack -= $amount;
        if ($this->attack < 0) {
            $this->attack = 0;
        }

        return $this;
    }

    public function removeDefensePoints($amount)
    {
        $this->defense -= $amount;
        if ($this->defense < 0) {
            $this->defense = 0;
        }

        return $this;
    }

    public function addSkillPoints($amount)
    {
        $this->skill += $amount;
        if ($this->skill > 100) {
            $this->skill = 100;
        }

        return $this;
    }

    public function removeSkillPoints($amount)
    {
        $this->skill -= $amount;
        if ($this->skill < 0) {
            $this->skill = 0;
        }

        return $this;
    }

}
