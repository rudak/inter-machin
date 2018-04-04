<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Bank\Loan;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Account
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 */
class Account
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
     * @ORM\Column(name="loan", type="integer", nullable=true)
     */
    private $loan;

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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * Account constructor.
     * @param int       $loan
     * @param int       $amount
     * @param \stdClass $user
     */
    public function __construct()
    {
    }

    public function hydratAccount(User $user)
    {
        $this->user   = $user;
        $this->amount = $user->getMoney();
        $this->date   = new \DateTime('NOW');
        $total        = 0;

        foreach ($user->getLoans() as $loan) {
            /** @var $loan Loan */
            if ($loan->getStatus() != Loan::STATUS_VALID) {
                continue;
            }
            $total += $loan->getAmount() - $loan->getRefunded();
        }
        $this->setLoan($total);
        return $this;
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
     * Set loan
     *
     * @param integer $loan
     *
     * @return Account
     */
    public function setLoan($loan)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return int
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Account
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Account
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
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Account
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
}

