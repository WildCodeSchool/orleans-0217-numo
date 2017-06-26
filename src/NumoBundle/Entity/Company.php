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
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255, nullable=true)
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return company
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return company
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
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return company
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return company
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return company
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
     * @return string
     */
    public function getPresentationTitle(): string
    {
        return $this->presentationTitle;
    }

    /**
     * @param string $presentationTitle
     * @return Company
     */
    public function setPresentationTitle(string $presentationTitle): Company
    {
        $this->presentationTitle = $presentationTitle;
        return $this;
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
     * @return Company
     */
    public function setPresentationContent(string $presentationContent): Company
    {
        $this->presentationContent = $presentationContent;
        return $this;
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
     * @return Company
     */
    public function setAdherentTitle(string $adherentTitle): Company
    {
        $this->adherentTitle = $adherentTitle;
        return $this;
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
     * @return Company
     */
    public function setAdherentContent(string $adherentContent): Company
    {
        $this->adherentContent = $adherentContent;
        return $this;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return company
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
     * @return mixed
     */
    public function getPdf()
    {
        return $this->pdf;
    }


    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
        return $this;
    }




}
