<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SourceLog
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\SourceLogRepository")
 */
class SourceLog
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
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visit_date", type="datetime")
     */
    private $visitDate;

    /**
     * @ORM\ManyToOne(targetEntity="NewsPost")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * */
    private $post;

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
     * Set source
     *
     * @param string $source
     * @return SourceLog
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set visitDate
     *
     * @param \DateTime $visitDate
     * @return SourceLog
     */
    public function setVisitDate($visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    /**
     * Get visitDate
     *
     * @return \DateTime 
     */
    public function getVisitDate()
    {
        return $this->visitDate;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost($post)
    {
        $this->post = $post;
    }

}
