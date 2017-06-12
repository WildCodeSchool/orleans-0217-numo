<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 *
 * @ORM\Table(name="adress")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\AdressRepository")
 */
class Adress
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
     * @ORM\Column(name="addr1", type="string", length=255)
     */
    private $addr1;

    /**
     * @var string
     *
     * @ORM\Column(name="addr2", type="string", length=255, nullable=true)
     */
    private $addr2;

    /**
     * @var int
     *
     * @ORM\Column(name="postalCode", type="integer")
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var float
     *
     * @ORM\Column(name="geoLat", type="float", nullable=true)
     */
    private $geoLat;

    /**
     * @var float
     *
     * @ORM\Column(name="geoLng", type="float", nullable=true)
     */
    private $geoLng;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="adresse")
     */

    private $users;


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
     * Set addr1
     *
     * @param string $addr1
     *
     * @return Adress
     */
    public function setAddr1($addr1)
    {
        $this->addr1 = $addr1;

        return $this;
    }

    /**
     * Get addr1
     *
     * @return string
     */
    public function getAddr1()
    {
        return $this->addr1;
    }

    /**
     * Set addr2
     *
     * @param string $addr2
     *
     * @return Adress
     */
    public function setAddr2($addr2)
    {
        $this->addr2 = $addr2;

        return $this;
    }

    /**
     * Get addr2
     *
     * @return string
     */
    public function getAddr2()
    {
        return $this->addr2;
    }

    /**
     * Set postalCode
     *
     * @param integer $postalCode
     *
     * @return Adress
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return int
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Adress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set geoLat
     *
     * @param float $geoLat
     *
     * @return Adress
     */
    public function setGeoLat($geoLat)
    {
        $this->geoLat = $geoLat;

        return $this;
    }

    /**
     * Get geoLat
     *
     * @return float
     */
    public function getGeoLat()
    {
        return $this->geoLat;
    }

    /**
     * Set geoLng
     *
     * @param float $geoLng
     *
     * @return Adress
     */
    public function setGeoLng($geoLng)
    {
        $this->geoLng = $geoLng;

        return $this;
    }

    /**
     * Get geoLng
     *
     * @return float
     */
    public function getGeoLng()
    {
        return $this->geoLng;
    }
}

