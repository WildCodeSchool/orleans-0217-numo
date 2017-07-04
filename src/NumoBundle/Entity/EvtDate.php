<?php

namespace NumoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvtDate
 *
 * @ORM\Table(name="evt_date")
 * @ORM\Entity(repositoryClass="NumoBundle\Repository\EvtDateRepository")
 */
class EvtDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="evtDate", type="date")
     */
    private $evtDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeStart", type="time")
     */
    private $timeStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeEnd", type="time")
     */
    private $timeEnd;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="evtDates", cascade={"all"})
     */
    private $event;

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
     * Set evtDate
     *
     * @param \DateTime $evtDate
     *
     * @return EvtDate
     */
    public function setEvtDate($evtDate)
    {
        $this->evtDate = $evtDate;

        return $this;
    }

    /**
     * Get evtDate
     *
     * @return \DateTime
     */
    public function getEvtDate()
    {
        return $this->evtDate;
    }

    /**
     * Set timeStart
     *
     * @param \DateTime $timeStart
     *
     * @return EvtDate
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Get timeStart
     *
     * @return \DateTime
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * Set timeEnd
     *
     * @param \DateTime $timeEnd
     *
     * @return EvtDate
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return \DateTime
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set event
     *
     * @param \NumoBundle\Entity\Event $event
     *
     * @return EvtDate
     */
    public function setEvent(\NumoBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \NumoBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
