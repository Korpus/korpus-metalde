<?php

namespace Korpus\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BandMember
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Korpus\DataBundle\Entity\BandMemberRepository")
 */
class BandMember
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
     * @ORM\Column(name="nickname", type="string", length=255)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="equipment", type="string", length=255)
     */
    private $equipment;

    /**
     * @var string
     *
     * @ORM\Column(name="musik", type="string", length=255)
     */
    private $musik;

    /**
     * @var string
     *
     * @ORM\Column(name="interessen", type="string", length=255)
     */
    private $interessen;

    /**
     * @var string
     *
     * @ORM\Column(name="filme", type="string", length=255)
     */
    private $filme;

    /**
     * @var string
     *
     * @ORM\Column(name="bestes_album", type="string", length=255)
     */
    private $bestesAlbum;

    /**
     * @var string
     *
     * @ORM\Column(name="beste_band", type="string", length=255)
     */
    private $besteBand;

    /**
     * @var string
     *
     * @ORM\Column(name="lieblings_essen", type="string", length=255)
     */
    private $lieblingsEssen;

    /**
     * @var string
     *
     * @ORM\Column(name="bester_drink", type="string", length=255)
     */
    private $besterDrink;

    /**
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     * */
    private $photo;

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
     * Set nickname
     *
     * @param string $nickname
     * @return BandMember
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return BandMember
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return BandMember
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return BandMember
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set equipment
     *
     * @param string $equipment
     * @return BandMember
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return string 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set musik
     *
     * @param string $musik
     * @return BandMember
     */
    public function setMusik($musik)
    {
        $this->musik = $musik;

        return $this;
    }

    /**
     * Get musik
     *
     * @return string 
     */
    public function getMusik()
    {
        return $this->musik;
    }

    /**
     * Set interessen
     *
     * @param string $interessen
     * @return BandMember
     */
    public function setInteressen($interessen)
    {
        $this->interessen = $interessen;

        return $this;
    }

    /**
     * Get interessen
     *
     * @return string 
     */
    public function getInteressen()
    {
        return $this->interessen;
    }

    /**
     * Set filme
     *
     * @param string $filme
     * @return BandMember
     */
    public function setFilme($filme)
    {
        $this->filme = $filme;

        return $this;
    }

    /**
     * Get filme
     *
     * @return string 
     */
    public function getFilme()
    {
        return $this->filme;
    }

    /**
     * Set bestesAlbum
     *
     * @param string $bestesAlbum
     * @return BandMember
     */
    public function setBestesAlbum($bestesAlbum)
    {
        $this->bestesAlbum = $bestesAlbum;

        return $this;
    }

    /**
     * Get bestesAlbum
     *
     * @return string 
     */
    public function getBestesAlbum()
    {
        return $this->bestesAlbum;
    }

    /**
     * Set besteBand
     *
     * @param string $besteBand
     * @return BandMember
     */
    public function setBesteBand($besteBand)
    {
        $this->besteBand = $besteBand;

        return $this;
    }

    /**
     * Get besteBand
     *
     * @return string 
     */
    public function getBesteBand()
    {
        return $this->besteBand;
    }

    /**
     * Set lieblingsEssen
     *
     * @param string $lieblingsEssen
     * @return BandMember
     */
    public function setLieblingsEssen($lieblingsEssen)
    {
        $this->lieblingsEssen = $lieblingsEssen;

        return $this;
    }

    /**
     * Get lieblingsEssen
     *
     * @return string 
     */
    public function getLieblingsEssen()
    {
        return $this->lieblingsEssen;
    }

    /**
     * Set besterDrink
     *
     * @param string $besterDrink
     * @return BandMember
     */
    public function setBesterDrink($besterDrink)
    {
        $this->besterDrink = $besterDrink;

        return $this;
    }

    /**
     * Get besterDrink
     *
     * @return string 
     */
    public function getBesterDrink()
    {
        return $this->besterDrink;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

}
