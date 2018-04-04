<?php

namespace AppBundle\Entity\Bank;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Loan
 *
 * @ORM\Table(name="bank_loan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Bank\LoanRepository")
 */
class Loan
{
    const STATUS_REQUEST = 'request';
    const STATUS_VALID   = 'validated';
    const STATUS_REFUSED = 'refused';
    const STATUS_CLOSED  = 'closed';


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
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="Amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="refunded", type="integer", nullable=true)
     */
    private $refunded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration", type="datetime", nullable=true)
     */
    private $expiration;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="smallint", nullable=true)
     */
    private $percentage;

    /**
     * Loan constructor.
     * @param \stdClass $user
     * @param \DateTime $date
     * @param string    $status
     */
    public function __construct(User $user)
    {
        $this->user     = $user;
        $this->date     = new \DateTime();
        $this->status   = self::STATUS_REQUEST;
        $this->refunded = 0;
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
     * @return Loan
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Loan
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
     * @return Loan
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
     * @return Loan
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
     * Set refunded
     *
     * @param integer $refunded
     *
     * @return Loan
     */
    public function setRefunded($refunded)
    {
        $this->refunded = $refunded;

        return $this;
    }

    /**
     * Get refunded
     *
     * @return int
     */
    public function getRefunded()
    {
        return $this->refunded;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return Loan
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return Loan
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }
}

