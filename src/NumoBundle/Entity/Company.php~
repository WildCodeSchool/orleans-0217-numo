<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\CompanyRepository")
 */
class Company
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
     * @ORM\Column(name="contactEmail", type="string", length=255)
     * @Assert\NotBlank(message="Merci de renseigner une adresse Email valide")
     * @Assert\Email(message = "l\'Email '{{ value }}' n'est pas valide")
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=255)
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     * @Assert\Length(
     *      max=7,
     *      maxMessage="Le code postal est trop long."
     * )
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank(message="L'adresse doit être renseignée.")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="presentationTitle", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     *
     */
    private $presentationTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="presentationContent", type="text")
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     *
     */
    private $presentationContent;

    /**
     * @var string
     *
     * @ORM\Column(name="adherentTitle", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     *
     */
    private $adherentTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="adherentContent", type="text")
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     *
     */
    private $adherentContent;

    /**
     * @ORM\Column(name="imageUrl", type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Merci de charger une image")
     * @Assert\Image
     *
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Merci d'uploader un PDF")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $pdf;

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
     * @return string
     */
    public function getContactEmail(): string
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail(string $contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
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
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPresentationTitle(): string
    {
        return $this->presentationTitle;
    }

    /**
     * @param string $presentationTitle
     */
    public function setPresentationTitle(string $presentationTitle)
    {
        $this->presentationTitle = $presentationTitle;
    }

    /**
     * @return string
     */
    public function getPresentationContent(): string
    {
        return $this->presentationContent;
    }

    /**
     * @param string $presentationContent
     */
    public function setPresentationContent(string $presentationContent)
    {
        $this->presentationContent = $presentationContent;
    }

    /**
     * @return string
     */
    public function getAdherentTitle(): string
    {
        return $this->adherentTitle;
    }

    /**
     * @param string $adherentTitle
     */
    public function setAdherentTitle(string $adherentTitle)
    {
        $this->adherentTitle = $adherentTitle;
    }

    /**
     * @return string
     */
    public function getAdherentContent(): string
    {
        return $this->adherentContent;
    }

    /**
     * @param string $adherentContent
     */
    public function setAdherentContent(string $adherentContent)
    {
        $this->adherentContent = $adherentContent;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * @param mixed $pdf
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
    }


}
