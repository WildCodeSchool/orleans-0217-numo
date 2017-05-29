<?php

// --- src/Appbundle/Entity/Location.php ---

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class Location
{

    private $uid;
    private $slug;

    /**
     * @var
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     */
    private $placename;
    private $latitude;
    private $longitude;
    private $address;
    private $department;
    private $region;
    private $city;
    private $postalCode;
    private $verified;
    private $ticketLink;
    private $pricingInfo;
    private $dates;

    public function __construct()
    {
        $this->dates = new ArrayCollection();
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
     * @return Location
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Location
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlacename()
    {
        return $this->placename;
    }

    /**
     * @param mixed $placename
     * @return Location
     */
    public function setPlacename($placename)
    {
        $this->placename = $placename;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Location
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     * @return Location
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     * @return Location
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $postalCode
     * @return Location
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param mixed $verified
     * @return Location
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTicketLink()
    {
        return $this->ticketLink;
    }

    /**
     * @param mixed $ticketLink
     * @return Location
     */
    public function setTicketLink($ticketLink)
    {
        $this->ticketLink = $ticketLink;
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
     * @return Location
     */
    public function setPricingInfo($pricingInfo)
    {
        $this->pricingInfo = $pricingInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * @param mixed $dates
     * @return Location
     */
    public function setDates(array $dates)
    {
        $this->dates = $dates;
        return $this;
    }



}