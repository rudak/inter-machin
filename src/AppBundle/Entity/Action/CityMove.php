<?php

namespace AppBundle\Entity\Action;

use AppBundle\Entity\City;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * CityMove
 *
 * @ORM\Table(name="action_city_move")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Action\CityMoveRepository")
 */
class CityMove implements ActionInterface
{
    const TYPE_RANDOM = 'random';
    const TYPE_USER   = 'user';
    const ACTION_NAME = 'citymove';

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30)
     */
    private $type;

    public function __construct(User $user, $type = self::TYPE_RANDOM)
    {
        $this->user = $user;
        $this->city = $user->getCity();
        $this->type = $type;
        $this->date = new \DateTime('NOW');
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
     * @return CityMove
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
     * Set city
     *
     * @param \stdClass $city
     *
     * @return CityMove
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \stdClass
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CityMove
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
     * @return CityMove
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

    public function getActionName()
    {
        return self::ACTION_NAME;
    }
}

