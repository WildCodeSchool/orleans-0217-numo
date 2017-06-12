<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="publishedDate", type="datetime")
     */
    private $publishedDate;


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
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return Published
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }
}
