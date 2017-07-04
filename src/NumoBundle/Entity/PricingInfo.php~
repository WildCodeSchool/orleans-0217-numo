<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PricingInfo
 *
 * @ORM\Table(name="pricing_info")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\PricingInfoRepository")
 */
class PricingInfo
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
     * @var string
     *
     * @ORM\Column(name="pricing", type="string", length=100)
     */
    private $pricing;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="pricingInfo")
     */
    private $events;


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
     * Set pricing
     *
     * @param string $pricing
     *
     * @return PricingInfo
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;

        return $this;
    }

    /**
     * Get pricing
     *
     * @return string
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $events
     * @return PricingInfo
     */
    public function setEvents($events)
    {
        $this->events = $events;
        return $this;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add event
     *
     * @param \NumoBundle\Entity\Event $event
     *
     * @return PricingInfo
     */
    public function addEvent(\NumoBundle\Entity\Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \NumoBundle\Entity\Event $event
     */
    public function removeEvent(\NumoBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
    }
}
