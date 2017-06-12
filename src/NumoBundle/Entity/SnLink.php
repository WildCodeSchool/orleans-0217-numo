<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SnLink
 *
 * @ORM\Table(name="sn_link")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\SnLinkRepository")
 */
class SnLink
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="snLinks")
     *
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="SocialNetwork", inversedBy="links")
     *
     */
    protected $socialNetworks;


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
     * Set url
     *
     * @param string $url
     *
     * @return SnLink
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->socialNetworks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \NumoBundle\Entity\User $user
     *
     * @return SnLink
     */
    public function setUser(\NumoBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NumoBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add socialNetwork
     *
     * @param \NumoBundle\Entity\SocialNetwork $socialNetwork
     *
     * @return SnLink
     */
    public function addSocialNetwork(\NumoBundle\Entity\SocialNetwork $socialNetwork)
    {
        $this->socialNetworks[] = $socialNetwork;

        return $this;
    }

    /**
     * Remove socialNetwork
     *
     * @param \NumoBundle\Entity\SocialNetwork $socialNetwork
     */
    public function removeSocialNetwork(\NumoBundle\Entity\SocialNetwork $socialNetwork)
    {
        $this->socialNetworks->removeElement($socialNetwork);
    }

    /**
     * Get socialNetworks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocialNetworks()
    {
        return $this->socialNetworks;
    }
}

