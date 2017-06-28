<?php

// --- src/NumoBundle/Entity/Event.php ---

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\EventRepository")
 */
class Event
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
     * @var int
     *
     * @ORM\Column(name="rejected", type="integer")
     */
    private $rejected;

    /**
     * @var string
     *
     * @Assert\Image()
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     *
     * @Assert\NotBlank(message="Une description minimum doit être indiquée.")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="freeText", type="text", nullable=true)
     */
    private $freeText;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="events")
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="placename", type="string", length=255)
     *
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $placename;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank(message="Une adresse valide doit être renseignée.")
     * @Assert\Length(
     *      max = 200,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="ticketLink", type="string", length=255, nullable=true)
     */
    private $ticketLink;

    /**
     * @ORM\ManyToOne(targetEntity="PricingInfo", inversedBy="events")
     */
    private $pricingInfo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationdate", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="EvtDate", mappedBy="event", cascade={"persist", "remove"})
     */
    private $evtDates;


    public function __construct()
    {
        $this->evtDates = new ArrayCollection();

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
     * Set rejected
     *
     * @param integer $rejected
     *
     * @return Event
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;

        return $this;
    }

    /**
     * Get rejected
     *
     * @return int
     */
    public function getRejected()
    {
        return $this->rejected;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set title
     *
     * @param string $title
     *
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
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set freeText
     *
     * @param string $freeText
     *
     * @return Event
     */
    public function setFreeText($freeText)
    {
        $this->freeText = $freeText;

        return $this;
    }

    /**
     * Get freeText
     *
     * @return string
     */
    public function getFreeText()
    {
        return $this->freeText;
    }

    /**
     * Set placename
     *
     * @param string $placename
     *
     * @return Event
     */
    public function setPlacename($placename)
    {
        $this->placename = $placename;

        return $this;
    }

    /**
     * Get placename
     *
     * @return string
     */
    public function getPlacename()
    {
        return $this->placename;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Event
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Event
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set ticketLink
     *
     * @param string $ticketLink
     *
     * @return Event
     */
    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;

        return $this;
    }

    /**
     * Get ticketLink
     *
     * @return string
     */
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Event
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPricingInfo()
    {
        return $this->pricingInfo;
    }

    /**
     * @param mixed $pricingInfo
     * @return Event
     */
    public function setPricingInfo($pricingInfo)
    {
        $this->pricingInfo = $pricingInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     * @return Event
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }


    /**
     * Add evtDate
     *
     * @param \NumoBundle\Entity\EvtDate $evtDate
     *
     * @return Event
     */
    public function addEvtDate(\NumoBundle\Entity\EvtDate $evtDate)
    {
        $this->evtDates[] = $evtDate;

        return $this;
    }

    /**
     * Remove evtDate
     *
     * @param \NumoBundle\Entity\EvtDate $evtDate
     */
    public function removeEvtDate(\NumoBundle\Entity\EvtDate $evtDate)
    {
        $this->evtDates->removeElement($evtDate);
    }

    /**
     * Get evtDates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvtDates()
    {
        return $this->evtDates;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Event
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }


}
