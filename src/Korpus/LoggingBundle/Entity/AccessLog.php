<?php

namespace Korpus\LoggingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessLog
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\LoggingBundle\Entity\AccessLogRepository")
 */
class AccessLog
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="source_ip", type="string", length=255)
     */
    private $sourceIp;

    /**
     * @var string
     *
     * @ORM\Column(name="target_resource", type="string", length=255)
     */
    private $targetResource;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="string", length=255)
     */
    private $referer;

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
     * Set sourceIp
     *
     * @param string $sourceIp
     * @return AccessLog
     */
    public function setSourceIp($sourceIp)
    {
        $this->sourceIp = $sourceIp;

        return $this;
    }

    /**
     * Get sourceIp
     *
     * @return string 
     */
    public function getSourceIp()
    {
        return $this->sourceIp;
    }

    /**
     * Set targetResource
     *
     * @param string $targetResource
     * @return AccessLog
     */
    public function setTargetResource($targetResource)
    {
        $this->targetResource = $targetResource;

        return $this;
    }

    /**
     * Get targetResource
     *
     * @return string 
     */
    public function getTargetResource()
    {
        return $this->targetResource;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return AccessLog
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
     * Set referer
     *
     * @param string $referer
     * @return AccessLog
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

}
