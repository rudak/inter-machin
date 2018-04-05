<?php

namespace AppBundle\Entity\Bank;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refund
 *
 * @ORM\Table(name="bank_refund")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Bank\RefundRepository")
 */
class Refund
{

    const TYPE_USER   = 'user';
    const TYPE_BANKER = 'banker';


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="smallint")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bank\Loan",cascade={"persist"})
     */
    private $loan;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25)
     */
    private $type;

    /**
     * Refund constructor.
     * @param Loan   $loan
     * @param        $amount
     * @param string $type
     */
    public function __construct(Loan $loan, $amount, $type = self::TYPE_USER)
    {
        $this->user   = $loan->getUser();
        $this->amount = $amount;
        $this->date   = new \DateTime('NOW');
        $this->loan   = $loan;
        $this->type   = $type;
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Refund
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
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
     * @return Refund
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
     * Set type
     *
     * @param string $type
     *
     * @return Refund
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Refund
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set loan
     *
     * @param \AppBundle\Entity\Bank\Loan $loan
     *
     * @return Refund
     */
    public function setLoan(\AppBundle\Entity\Bank\Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return \AppBundle\Entity\Bank\Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }
}
