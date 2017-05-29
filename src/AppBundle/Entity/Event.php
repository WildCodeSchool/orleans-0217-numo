<?php

// --- src/Appbundle/Entity/Event.php ---

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Event
{

    private $uid;
    private $link;
    private $updatedAt;
    private $spacetimeinfo;
    private $image;
    private $imageThumb;

    /**
     * @var
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $title;

    /**
     * @var
     * @Assert\NotBlank(message="Une description minimum doit être indiquée.")
     */
    private $description;
    private $freeText = '';
    private $tags = '';










    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     * @return Event
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return Event
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Event
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpacetimeinfo()
    {
        return $this->spacetimeinfo;
    }

    /**
     * @param mixed $spacetimeinfo
     * @return Event
     */
    public function setSpacetimeinfo($spacetimeinfo)
    {
        $this->spacetimeinfo = $spacetimeinfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageThumb()
    {
        return $this->imageThumb;
    }

    /**
     * @param mixed $imageThumb
     * @return Event
     */
    public function setImageThumb($imageThumb)
    {
        $this->imageThumb = $imageThumb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFreeText()
    {
        return $this->freeText;
    }

    /**
     * @param mixed $freeText
     * @return Event
     */
    public function setFreeText($freeText)
    {
        $this->freeText = $freeText;
        return $this;
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
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param mixed $locations
     * @return Event
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
        return $this;
    }

}
