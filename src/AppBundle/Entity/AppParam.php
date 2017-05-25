<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppParam
 *
 * @ORM\Table(name="app_param")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppParamRepository")
 */
class AppParam
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
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string", length=255)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="webUrl", type="string", length=255)
     */
    private $webUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="agendaName", type="string", length=255)
     */
    private $agendaName;

    /**
     * @var string
     *
     * @ORM\Column(name="contactEmail", type="string", length=255)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="AdminEmail", type="string", length=255)
     */
    private $adminEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="smtpServer", type="string", length=255)
     */
    private $smtpServer;

    /**
     * @var string
     *
     * @ORM\Column(name="smtpEmail", type="string", length=255)
     */
    private $smtpEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="smtpPassword", type="string", length=255)
     */
    private $smtpPassword;


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
     * Set address
     *
     * @param string $address
     *
     * @return AppParam
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
     * @return AppParam
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
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return AppParam
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
     * Set webUrl
     *
     * @param string $webUrl
     *
     * @return AppParam
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
     * Set agendaName
     *
     * @param string $agendaName
     *
     * @return AppParam
     */
    public function setAgendaName($agendaName)
    {
        $this->agendaName = $agendaName;

        return $this;
    }

    /**
     * Get agendaName
     *
     * @return string
     */
    public function getAgendaName()
    {
        return $this->agendaName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return AppParam
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
     * Set adminEmail
     *
     * @param string $adminEmail
     *
     * @return AppParam
     */
    public function setAdminEmail($adminEmail)
    {
        $this->adminEmail = $adminEmail;

        return $this;
    }

    /**
     * Get adminEmail
     *
     * @return string
     */
    public function getAdminEmail()
    {
        return $this->adminEmail;
    }

    /**
     * Set smtpServer
     *
     * @param string $smtpServer
     *
     * @return AppParam
     */
    public function setSmtpServer($smtpServer)
    {
        $this->smtpServer = $smtpServer;

        return $this;
    }

    /**
     * Get smtpServer
     *
     * @return string
     */
    public function getSmtpServer()
    {
        return $this->smtpServer;
    }

    /**
     * Set smtpEmail
     *
     * @param string $smtpEmail
     *
     * @return AppParam
     */
    public function setSmtpEmail($smtpEmail)
    {
        $this->smtpEmail = $smtpEmail;

        return $this;
    }

    /**
     * Get smtpEmail
     *
     * @return string
     */
    public function getSmtpEmail()
    {
        return $this->smtpEmail;
    }

    /**
     * Set smtpPassword
     *
     * @param string $smtpPassword
     *
     * @return AppParam
     */
    public function setSmtpPassword($smtpPassword)
    {
        $this->smtpPassword = $smtpPassword;

        return $this;
    }

    /**
     * Get smtpPassword
     *
     * @return string
     */
    public function getSmtpPassword()
    {
        return $this->smtpPassword;
    }
}

