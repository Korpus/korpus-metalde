<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\EventRepository")
 */
class Event
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=true)
     */
    private $editDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="datetime")
     */
    private $eventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_link", type="string", length=255)
     */
    private $facebookLink;

    /**
     * @var string
     *
     * @ORM\Column(name="venue", type="string", length=255)
     */
    private $venue;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumn(name="flyer_id", referencedColumnName="id")
     * */
    private $flyer;

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
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Event
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set editDate
     *
     * @param \DateTime $editDate
     * @return Event
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Get editDate
     *
     * @return \DateTime 
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set facebookLink
     *
     * @param string $facebookLink
     * @return Event
     */
    public function setFacebookLink($facebookLink)
    {
        $this->facebookLink = $facebookLink;

        return $this;
    }

    /**
     * Get facebookLink
     *
     * @return string 
     */
    public function getFacebookLink()
    {
        return $this->facebookLink;
    }

    public function getVenue()
    {
        return $this->venue;
    }

    public function setVenue($venue)
    {
        $this->venue = $venue;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getFlyer()
    {
        return $this->flyer;
    }

    public function setFlyer($flyer)
    {
        $this->flyer = $flyer;
    }

}
