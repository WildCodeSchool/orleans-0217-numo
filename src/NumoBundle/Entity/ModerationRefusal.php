<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModerationRefusal
 *
 * @ORM\Table(name="moderation_refusal")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\ModerationRefusalRepository")
 */
class ModerationRefusal
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="contactEmail", type="string", length=255)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;
    /**
     * @var integer
     *
     * @ORM\Column(name="eventId", type="integer")
     */

    private $eventId;

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
     * Set title
     *
     * @param string $title
     *
     * @return ModerationRefusal
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return ModerationRefusal
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
     * Set comment
     *
     * @param string $comment
     *
     * @return ModerationRefusal
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @param int $eventId
     */
    public function setEventId(int $eventId)
    {
        $this->eventId = $eventId;
    }


}

