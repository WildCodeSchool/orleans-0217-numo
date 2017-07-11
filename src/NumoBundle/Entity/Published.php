<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NumoBundle\Entity\User;

/**
 * Published
 *
 * @ORM\Table(name="published")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\PublishedRepository")
 */
class Published
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
     * @ORM\Column(name="uid", type="string", length=15)
     */
    private $uid;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     *
     */
    private $title;
    /**
     * @ORM\Column(name="deleted", type="integer")
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="publications")
     *
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="authorUpdateDate", type="datetime")
     */
    private $authorUpdateDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="moderations")
     *
     */
    private $moderator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="moderatorUpdateDate", type="datetime")
     */
    private $moderatorUpdateDate;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="locationUid", type="string", length=15)
     */
    private $locationUid;


    /**
     * Published constructor.
     * @param Event $event
     * @param string $uid
     * @param $moderator
     */
    public function __construct(Event $event, string $uid, string $locationUid, User $moderator)
    {
        $this
            ->setDeleted(0)
            ->setUid($uid)
            ->setAuthor($event->getAuthor())
            ->setAuthorUpdateDate($event->getCreationDate())
            ->setModerator($moderator)
            ->setModeratorUpdateDate(new \DateTime)
            ->setTitle($event->getTitle())
            ->setLocationUid($locationUid)
            ->setImage($event->getImage());
    }

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
     * Set uid
     *
     * @param string $uid
     *
     * @return Published
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Published
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     * @return Published
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Published
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthorUpdateDate()
    {
        return $this->authorUpdateDate;
    }

    /**
     * @param mixed $authorUpdateDate
     * @return Published
     */
    public function setAuthorUpdateDate($authorUpdateDate)
    {
        $this->authorUpdateDate = $authorUpdateDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModerator()
    {
        return $this->moderator;
    }

    /**
     * @param mixed $moderator
     * @return Published
     */
    public function setModerator($moderator)
    {
        $this->moderator = $moderator;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModeratorUpdateDate(): \DateTime
    {
        return $this->moderatorUpdateDate;
    }

    /**
     * @param \DateTime $moderatorUpdateDate
     * @return Published
     */
    public function setModeratorUpdateDate(\DateTime $moderatorUpdateDate): Published
    {
        $this->moderatorUpdateDate = $moderatorUpdateDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Published
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocationUid(): string
    {
        return $this->locationUid;
    }

    /**
     * @param string $locationUid
     * @return Published
     */
    public function setLocationUid(string $locationUid): Published
    {
        $this->locationUid = $locationUid;
        return $this;
    }


}
