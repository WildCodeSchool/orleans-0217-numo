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
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     * @return AppParam
     */
    public function setPublicKey(string $publicKey): AppParam
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     * @return AppParam
     */
    public function setSecretKey(string $secretKey): AppParam
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15)
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
     * @ORM\Column(name="publicKey", type="string", length=255)
     */
    private $publicKey;

    /**
     * @var string
     *
     * @ORM\Column(name="secretKey", type="string", length=255)
     */
    private $secretKey;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AppParam
     */
    public function setId(int $id): AppParam
    {
        $this->id = $id;
        return $this;
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
     * @return AppParam
     */
    public function setAddress(string $address): AppParam
    {
        $this->address = $address;
        return $this;
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
     * @return AppParam
     */
    public function setPhone(string $phone): AppParam
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return AppParam
     */
    public function setImageUrl(string $imageUrl): AppParam
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebUrl(): string
    {
        return $this->webUrl;
    }

    /**
     * @param string $webUrl
     * @return AppParam
     */
    public function setWebUrl(string $webUrl): AppParam
    {
        $this->webUrl = $webUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgendaName(): string
    {
        return $this->agendaName;
    }

    /**
     * @param string $agendaName
     * @return AppParam
     */
    public function setAgendaName(string $agendaName): AppParam
    {
        $this->agendaName = $agendaName;
        return $this;
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
     * @return AppParam
     */
    public function setContactEmail(string $contactEmail): AppParam
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdminEmail(): string
    {
        return $this->adminEmail;
    }

    /**
     * @param string $adminEmail
     * @return AppParam
     */
    public function setAdminEmail(string $adminEmail): AppParam
    {
        $this->adminEmail = $adminEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSmtpServer(): string
    {
        return $this->smtpServer;
    }

    /**
     * @param string $smtpServer
     * @return AppParam
     */
    public function setSmtpServer(string $smtpServer): AppParam
    {
        $this->smtpServer = $smtpServer;
        return $this;
    }

    /**
     * @return string
     */
    public function getSmtpEmail(): string
    {
        return $this->smtpEmail;
    }

    /**
     * @param string $smtpEmail
     * @return AppParam
     */
    public function setSmtpEmail(string $smtpEmail): AppParam
    {
        $this->smtpEmail = $smtpEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getSmtpPassword(): string
    {
        return $this->smtpPassword;
    }

    /**
     * @param string $smtpPassword
     * @return AppParam
     */
    public function setSmtpPassword(string $smtpPassword): AppParam
    {
        $this->smtpPassword = $smtpPassword;
        return $this;
    }



}

