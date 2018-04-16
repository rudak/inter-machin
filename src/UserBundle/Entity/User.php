<?php

namespace UserBundle\Entity;

use AppBundle\Entity\City;
use AppBundle\Entity\Competences;
use AppBundle\Utils\AppConfig;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
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

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfBirth", type="datetime")
     */
    private $dateOfBirth;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Bank\Loan",mappedBy="user")
     */
    private $loans;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City",inversedBy="users")
     */
    private $city;

    /**
     * @ORM\Column(name="action_point", type="smallint")
     */
    private $action;

    public function __construct()
    {
        parent::__construct();
        $this->alive       = true;
        $this->money       = 20;
        $this->competences = new Competences();
        $this->action      = AppConfig::USER_DEFAULT_ACTION_POINT;
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
        return $this->competences->getLife() > 0;
    }


    public function kill()
    {
        $this->setAlive(false);
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
        $this->money = $money;

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

    public function addMoney($amount)
    {
        $this->money += $amount;
    }

    public function removeMoney($amount)
    {
        $this->money -= $amount;
        if ($this->money < 0) {
            $this->money = 0;
        }
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

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Add loan
     *
     * @param \AppBundle\Entity\Bank\Loan $loan
     *
     * @return User
     */
    public function addLoan(\AppBundle\Entity\Bank\Loan $loan)
    {
        $this->loans[] = $loan;

        return $this;
    }

    /**
     * Remove loan
     *
     * @param \AppBundle\Entity\Bank\Loan $loan
     */
    public function removeLoan(\AppBundle\Entity\Bank\Loan $loan)
    {
        $this->loans->removeElement($loan);
    }

    /**
     * Get loans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    public function addActionPoint($number)
    {
        $this->action += $number;
        $this->action = $this->action > AppConfig::USER_MAX_ACTION_POINT ? AppConfig::USER_MAX_ACTION_POINT : $this->action;
        return $this->action;
    }

    public function removeActionPoint($number)
    {
        $this->action -= $number;
        $this->action = $this->action < 0 ? 0 : $this->action;
        return $this->action;
    }
}
