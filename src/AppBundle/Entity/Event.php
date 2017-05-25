<?php

// --- src/Appbundle/Entity/Event.php ---

namespace AppBundle\Entity;


class Event
{

    private $uid;
    private $agenda_slug;
    private $link;
    private $updatedAt;
    private $spacetimeinfo;
    private $image;
    private $imageThumb;
    private $title;
    private $description;
    private $freeText;
    private $tags;
    private $locations = [];
    private $thirdParties = [];

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     * @return Agenda
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgendaSlug()
    {
        return $this->agenda_slug;
    }

    /**
     * @param mixed $agenda_slug
     * @return Agenda
     */
    public function setAgendaSlug($agenda_slug)
    {
        $this->agenda_slug = $agenda_slug;
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
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
     * @return Agenda
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return array
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @param array $locations
     * @return Agenda
     */
    public function setLocations($locations)
    {
        $this->locations = $locations;
        return $this;
    }

    /**
     * @return array
     */
    public function getThirdParties()
    {
        return $this->thirdParties;
    }

    /**
     * @param array $thirdParties
     * @return Agenda
     */
    public function setThirdParties($thirdParties)
    {
        $this->thirdParties = $thirdParties;
        return $this;
    }

    public function hydrate(array $values)
    {

    }
}




