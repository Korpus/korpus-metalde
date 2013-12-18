<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\ArticleGroupRepository")
 */
class ArticleGroup
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
     * @ORM\OneToMany(targetEntity="Article", mappedBy="group")
     */
    protected $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection;
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
     * @return ArticleGroup
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

    public function getArticles()
    {
        return $this->articles;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

}
