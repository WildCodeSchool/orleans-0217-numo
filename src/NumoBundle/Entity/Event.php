<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="freeText", type="text")
     */
    private $freeText;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="placename", type="string", length=255)
     */
    private $placename;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
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
     * @ORM\Column(name="ticketLink", type="string", length=255)
     */
    private $ticketLink;

    /**
     * @var string
     *
     * @ORM\Column(name="pricingInfo", type="string", length=255)
     */
    private $pricingInfo;

    /**
     * @ORM\OneToMany(targetEntity="EvtDate", mappedBy="event")
     */
    private $evtDates;


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
     * Set status
     *
     * @param integer $status
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set tags
     *
     * @param string $tags
     *
     * @return Event
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
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
     * Set pricingInfo
     *
     * @param string $pricingInfo
     *
     * @return Event
     */
    public function setPricingInfo($pricingInfo)
    {
        $this->pricingInfo = $pricingInfo;

        return $this;
    }

    /**
     * Get pricingInfo
     *
     * @return string
     */
    public function getPricingInfo()
    {
        return $this->pricingInfo;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->evtDates = new \Doctrine\Common\Collections\ArrayCollection();
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
}
