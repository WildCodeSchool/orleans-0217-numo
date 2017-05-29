<?php

// --- src/Appbundle/Entity/EvtDate.php ---

namespace AppBundle\Entity;

class EvtDate
{

    private $evtDate;
    private $timeStart;
    private $timeEnd;

    /**
     * @return mixed
     */
    public function getEvtDate()
    {
        return $this->evtDate;
    }

    /**
     * @param mixed $evtDate
     * @return EvtDate
     */
    public function setEvtDate($evtDate)
    {
        $this->evtDate = $evtDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * @param mixed $timeStart
     * @return EvtDate
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * @param mixed $timeEnd
     * @return EvtDate
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
        return $this;
    }



}