<?php

namespace NumoBundle\Entity;

class OaEvent
{
    private $id = 0;
    private $status = 0;
    private $link = '';
    private $image = '';
    private $title = '';
    private $description = '';
    private $freeText = '';
    private $tags = '';
    private $placename = '';
    private $address = '';
    private $latitude = 0.0;
    private $longitude = 0.0;
    private $ticketLink = '';
    private $pricingInfo = '';
    private $evtDates = [];
    // structure $evtDates : chaque élément du tableau est un tableau asociatif de 3 éléments :
    //     ['evtDate' => 'AAAA-MM-JJ', 'timeStart' => 'HH:MM:SS', 'timeEnd' => 'HH:MM:SS']

    public function hydrate (array $properties)
    {
        foreach ($properties as $key => $value) {
            if (property_exists($this)) {
                $method = 'set'.ucfirst($key);
                $this->$method($value);
            }
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param $image
     */
    public function setLink($link='')
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param $image
     */
    public function setImage($image='')
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description='')
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFreeText(): string
    {
        return $this->freeText;
    }

    /**
     * @param $freeText
     */
    public function setFreeText($freeText='')
    {
        $this->freeText = $freeText;
    }

    /**
     * @return string
     */
    public function getTags(): string
    {
        return $this->tags;
    }

    /**
     * @param $tags
     */
    public function setTags($tags='')
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getPlacename(): string
    {
        return $this->placename;
    }

    /**
     * @param string $placename
     */
    public function setPlacename(string $placename)
    {
        $this->placename = $placename;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getTicketLink(): string
    {
        return $this->ticketLink;
    }

    /**
     * @param $ticketLink
     */
    public function setTicketLink($ticketLink='')
    {
        $this->ticketLink = $ticketLink;
    }

    /**
     * @return string
     */
    public function getPricingInfo(): string
    {
        return $this->pricingInfo;
    }

    /**
     * @param $pricingInfo
     */
    public function setPricingInfo($pricingInfo='')
    {
        $this->pricingInfo = $pricingInfo;
    }

    /**
     * @return array
     */
    public function getEvtDates(): array
    {
        return $this->evtDates;
    }

    /**
     * @param array $evtDates
     */
    public function setEvtDates(array $evtDates)
    {
        $this->evtDates = $evtDates;
    }


}