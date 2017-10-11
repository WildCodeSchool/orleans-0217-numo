<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Le texte saisi doit contenir au moins {{ limit }} caractères.")
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères.")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="tags")
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
     * Set category
     *
     * @param string $category
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return Category
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
     * @return Category
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
