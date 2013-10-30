<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Record
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\RecordRepository")
 */
class Record
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_date", type="datetime")
     */
    private $publishDate;

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
     * @ORM\ManyToMany(targetEntity="RecordTrack")
     * @ORM\JoinTable(name="records_tracks",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="track_id", referencedColumnName="id", unique=true)}
     *      )
     * */
    private $tracks;

    /**
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumn(name="cover_id", referencedColumnName="id")
     * */
    private $cover;

    public function __construct()
    {
        $this->tracks = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Record
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
     * Set publishDate
     *
     * @param \DateTime $publishDate
     * @return Record
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function getEditDate()
    {
        return $this->editDate;
    }

    public function setEditDate(\DateTime $editDate)
    {
        $this->editDate = $editDate;
        return $this;
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $tracks
     * @return \Korpus\DataBundle\Entity\Record
     */
    public function setTracks(\Doctrine\Common\Collections\ArrayCollection $tracks)
    {
        $this->tracks = $tracks;
        return $this;
    }

    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover)
    {
        $this->cover = $cover;
    }

}
