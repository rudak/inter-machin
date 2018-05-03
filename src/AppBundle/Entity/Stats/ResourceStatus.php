<?php

namespace AppBundle\Entity\Stats;

use AppBundle\Entity\Trade\Resource;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResourceStatus
 *
 * @ORM\Table(name="stats_resource_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Stats\ResourceStatusRepository")
 */
class ResourceStatus
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
     * @var Resource
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Trade\Resource")
     */
    private $resource;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * ResourceStatus constructor.
     * @param Resource $resource
     * @param int      $value
     */
    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
        $this->value    = $resource->getValue();
        $this->date     = new \DateTime('NOW');
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
     * @return ResourceStatus
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
     * Set value
     *
     * @param integer $value
     *
     * @return ResourceStatus
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set resource
     *
     * @param Resource $resource
     *
     * @return ResourceStatus
     */
    public function setResource(Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }
}
