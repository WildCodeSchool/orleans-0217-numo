<?php

namespace NumoBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le nom est trop court.",
     *     maxMessage="Le nom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Entrez votre prénom.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=1,
     *     max=255,
     *     minMessage="Le prénom est trop court.",
     *     maxMessage="Le prénom est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="text", length=653, nullable=true)
     *
     * @Assert\Length(
     *     max=653,
     *     maxMessage="Le message est trop long.",
     * )
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Image(
     *     maxSize = "1024k",
     *     maxSizeMessage="L'image est trop lourde.",
     *     allowLandscape = false,
     *     allowLandscapeMessage = "Les formats paysages ne sont pas autorisés"
     * )
     */
    protected $imageUrl;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     *
     * @Assert\NotBlank(groups={"Registration", "Profile"})
     */
    protected $trust;


    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     *
     * @Assert\NotBlank(message="Entrez le lien de votre site web.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Le lien est trop court.",
     *     maxMessage="Le lien est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $webSite;

    /**
     * @ORM\Column(type="text", length=5550, nullable=true, options={"default" : null})
     *
     * @Assert\NotBlank(message="Entrez votre description.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=5550,
     *     minMessage="Le texte est trop court.",
     *     maxMessage="Le texte est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $freeText;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=3,
     *     max=50,
     *     minMessage="Le numéro est trop court.",
     *     maxMessage="Le numéro est trop long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=250, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     max=250,
     *     maxMessage="L\'adresse saisie est trop longue"
     * )
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=7, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=5,
     *     max=7,
     *     minMessage="Le code postal est trop court.",
     *     maxMessage="Le code postal est trop long."
     * )
     */
    protected $postalCode;

    /**
     * @ORM\Column(type="string", length=250, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=3,
     *     max=250,
     *     minMessage="Le texte saisi est trop court.",
     *     maxMessage="Le texte saisi est trop long."
     * )
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=3,
     *     minMessage="Le texte saisi est trop court.",
     * )
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=3,
     *     minMessage="Le texte saisi est trop court.",
     * )
     */
    protected $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" : null})
     *
     * @Assert\Length(
     *     min=3,
     *     minMessage="Le numéro est trop court.",
     * )
     */
    protected $linkedin;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="author")
     */
    protected $events;

    /**
     * @ORM\OneToMany(targetEntity="Published", mappedBy="author")
     *
     */
    protected $publications;

    /**
     * @ORM\OneToMany(targetEntity="Published", mappedBy="moderator")
     *
     */
    protected $moderations;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getTrust()
    {
        return $this->trust;
    }

    /**
     * @param mixed $trust
     */
    public function setTrust($trust)
    {
        $this->trust = $trust;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);
        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return User
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * Set freeText
     *
     * @param string $freeText
     *
     * @return User
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
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
     * @return User
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
     * @return User
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * Add publication
     *
     * @param \NumoBundle\Entity\Published $publication
     *
     * @return User
     */
    public function addPublication(\NumoBundle\Entity\Published $publication)
    {
        $this->publications[] = $publication;

        return $this;
    }

    /**
     * Remove publication
     *
     * @param \NumoBundle\Entity\Published $publication
     */
    public function removePublication(\NumoBundle\Entity\Published $publication)
    {
        $this->publications->removeElement($publication);
    }

    /**
     * Get publications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * Add moderation
     *
     * @param \NumoBundle\Entity\Published $moderation
     *
     * @return User
     */
    public function addModeration(\NumoBundle\Entity\Published $moderation)
    {
        $this->moderations[] = $moderation;

        return $this;
    }

    /**
     * Remove moderation
     *
     * @param \NumoBundle\Entity\Published $moderation
     */
    public function removeModeration(\NumoBundle\Entity\Published $moderation)
    {
        $this->moderations->removeElement($moderation);
    }

    /**
     * Get moderations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModerations()
    {
        return $this->moderations;
    }


    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return User
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return User
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return User
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Add event
     *
     * @param \NumoBundle\Entity\Event $event
     *
     * @return User
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

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Check if a user as a defined role
     *
     */
    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }

}
