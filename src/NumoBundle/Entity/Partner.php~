<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Partner
 *
 * @ORM\Table(name="partner")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\PartnerRepository")
 */
class Partner
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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Le nom doit être renseigné")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="webUrl", type="string", length=255, nullable=true)
     *
     * @Assert\Url(message = "L\'url saisie n\'est pas valide")
     */
    private $webUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255)
     *
     * @Assert\File(
     *     maxSize = "2024k",
     *     maxSizeMessage="L'image est trop lourde.",
     *     mimeTypes = {"application/jpg", "application/jpeg", "application/png", "application/gif"},
     *     mimeTypesMessage = "Merci d'uploader une image valide"
     * )
     */
    private $imageUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;


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
     * Set name
     *
     * @param string $name
     *
     * @return Partner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set webUrl
     *
     * @param string $webUrl
     *
     * @return Partner
     */
    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    /**
     * Get webUrl
     *
     * @return string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Partner
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Partner
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }
}
