<?php

namespace AppBundle\Entity\Stats;

use AppBundle\Entity\City;
use Doctrine\ORM\Mapping as ORM;

/**
 * CityPrice
 *
 * @ORM\Table(name="stats_city_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Stats\CityPriceRepository")
 */
class CityStatus
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
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $city;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="smallint", nullable=true)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="smallint")
     */
    private $price;

    /**
     * CityStatus constructor.
     * @param City $city
     * @param      $amount
     * @param      $price
     */
    public function __construct(City $city, $amount, $price)
    {
        $this->city   = $city;
        $this->date   = new \DateTime('NOW');
        $this->amount = $amount;
        $this->price  = $price;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CityStatus
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return CityStatus
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
     * Set price
     *
     * @param integer $price
     *
     * @return CityStatus
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set city
     *
     * @param City $city
     *
     * @return CityStatus
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }
}
