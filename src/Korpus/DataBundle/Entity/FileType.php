<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FileType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\FileTypeRepository")
 */
class FileType
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
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="FileTypeGroup")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * */
    private $group;

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
     * @return FileType
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return FileType
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }

}
