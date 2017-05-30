<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PageContent
 *
 * @ORM\Table(name="page_content")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\PageContentRepository")
 */
class PageContent
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModif", type="datetime")
     */
    private $lastModif;


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
     * @return PageContent
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
     * Set content
     *
     * @param string $content
     *
     * @return PageContent
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set lastModif
     *
     * @param \DateTime $lastModif
     *
     * @return PageContent
     */
    public function setLastModif($lastModif)
    {
        $this->lastModif = $lastModif;

        return $this;
    }

    /**
     * Get lastModif
     *
     * @return \DateTime
     */
    public function getLastModif()
    {
        return $this->lastModif;
    }
}

