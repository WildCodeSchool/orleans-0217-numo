<?php

namespace NumoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * Class OaEvent
 * @package NumoBundle\Entity
 */
class OaEvent
{
    private $id;
    private $status;
    private $link;
    private $image;

    /**
     * @var
     * @Assert\NotBlank(message="Le nom doit être renseigné.")
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $title;

    /**
     * @var
     * @Assert\NotBlank(message="Une description minimum doit être indiquée.")
     */
    private $description;

    private $freeText;

    private $tags;

    /**
     * @var
     * @Assert\NotBlank(message="Ce champ doit être renseigné.")
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $placename;

    /**
     * @var
     * @Assert\NotBlank(message="Une adresse valide doit être renseignée.")
     * @Assert\Length(
     *      max = 200,
     *      maxMessage = "Le texte saisi ne doit pas excéder {{ limit }} caractères")
     */
    private $address;

    private $latitude;

    private $longitude;

    private $ticketLink;

    private $pricingInfo;

    /**
     * @var array
     * liste les dates passees de l'evenement (peut etre vide)
     * structure $oldDates : chaque élément du tableau est un tableau asociatif de 3 éléments :
     *     ['evtDate' => 'AAAA-MM-JJ', 'timeStart' => 'HH:MM:SS', 'timeEnd' => 'HH:MM:SS']
     */
    private $oldDates;

    /**
     * @var array
     * liste les dates a venir de l'evenement (peut etre vide) - meme structure que $oldDates
     */
    private $newDates;

    public function __construct()
    {
        $this
            ->setStatus(1)
            ->setLink('')
            ->setImage('')
            ->setTitle('')
            ->setDescription('')
            ->setFreeText('')
            ->setTags('')
            ->setPlacename('')
            ->setAddress('')
            ->setLatitude(0.0)
            ->setLongitude(0.0)
            ->setTicketLink('')
            ->setPricingInfo('')
            ->setOldDates([])
            ->setNewDates([]);
    }


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
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     *
     */
    public function setLink($link)
    {
        if (null === $link) {
            $link = '';
        }
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param $image
     */
    public function setImage($image)
    {
        if (null === $image) {
            $image = '';
        }
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        if (null === $description) {
            $description = '';
        }
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getFreeText(): string
    {
        return $this->freeText;
    }

    /**
     * @param $freeText
     */
    public function setFreeText($freeText)
    {
        if (null === $freeText) {
            $freeText = '';
        }
        $this->freeText = $freeText;
        return $this;
    }

    /**
     * @return string
     */
    public function getTags(): string
    {
        return $this->tags;
    }

    /**
     * @param $tags
     */
    public function setTags($tags)
    {
        if (null === $tags) {
            $tags = '';
        }
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlacename(): string
    {
        return $this->placename;
    }

    /**
     * @param string $placename
     */
    public function setPlacename(string $placename)
    {
        $this->placename = $placename;
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
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getTicketLink(): string
    {
        return $this->ticketLink;
    }

    /**
     * @param $ticketLink
     */
    public function setTicketLink($ticketLink)
    {
        if (null === $ticketLink) {
            $ticketLink = '';
        }
        $this->ticketLink = $ticketLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getPricingInfo(): string
    {
        return $this->pricingInfo;
    }

    /**
     * @param $pricingInfo
     */
    public function setPricingInfo($pricingInfo)
    {
        if (null === $pricingInfo) {
            $pricingInfo = '';
        }
        $this->pricingInfo = $pricingInfo;
        return $this;
    }

    /**
     * @return array
     */
    public function getOldDates(): array
    {
        return $this->oldDates;
    }

    /**
     * @param array $oldDates
     * @return OaEvent
     */
    public function setOldDates(array $oldDates): OaEvent
    {
        $this->oldDates = $oldDates;
        return $this;
    }

    /**
     * @return array
     */
    public function getNewDates(): array
    {
        return $this->newDates;
    }

    /**
     * @param array $newDate
     * @return OaEvent
     */
    public function setNewDates(array $newDates): OaEvent
    {
        $this->newDates = $newDates;
        return $this;
    }


}