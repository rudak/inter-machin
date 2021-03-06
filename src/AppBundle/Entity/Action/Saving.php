<?php

namespace AppBundle\Entity\Action;

use AppBundle\Entity\Action\ActionInterface;
use AppBundle\Repository\Action\ActionRepositoryInterface;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Saving
 *
 * @ORM\Table(name="action_saving")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\SavingRepository")
 */
class Saving implements ActionInterface
{
    const ACTION_NAME = 'saving';
    const TYPE_BANKER = 'banker';
    const TYPE_USER   = 'user';

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
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",cascade={"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * Saving constructor.
     * @param \DateTime $date
     * @param User      $user
     */
    public function __construct(User $user, $type = self::TYPE_USER)
    {
        $this->date = new \DateTime('NOW');
        $this->user = $user;
        $this->type = $type;
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Saving
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
     * @return Saving
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
     * @param User $user
     *
     * @return Saving
     */
    public function setUser(User $user = null)
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

    public function getActionName()
    {
        return self::ACTION_NAME;
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
