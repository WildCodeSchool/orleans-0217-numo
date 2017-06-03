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
     *     min=3,
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
     *     min=3,
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
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Length(
     *     max=255,
     *     maxMessage="L'url est trop longue.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $imageUrl;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(groups={"Registration", "Profile"})
     */
    protected $trust;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="text", length=5550)
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
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank(message="Entrez votre numéro de téléphone.", groups={"Registration", "Profile"})
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
     * @ORM\ManyToOne(targetEntity="Adress", inversedBy="users")
     *
     */
    protected $adress;

    /**
     * @ORM\OneToMany(targetEntity="SnLink", mappedBy="user")
     *
     */
    protected $snLink;



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


    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
