<?php

namespace NumoBundle\Entity;


class SelectEvent
{
    private $startDate;
    private $endDate;
    private $category;
    private $passed;
    private $id;

    public function reset()
    {
        $this
            ->setStartDate(null)
            ->setEndDate(null)
            ->setCategory('')
            ->setPassed(0)
            ->setId('');
    }
    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     * @return SelectEvent
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     * @return SelectEvent
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $tags
     * @return SelectEvent
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassed()
    {
        return $this->passed;
    }

    /**
     * @param mixed $passed
     * @return SelectEvent
     */
    public function setPassed($passed)
    {
        $this->passed = $passed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return SelectEvent
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function DatesControl()
    {
        // --- contrôle dates
        // - si une seule date , 2eme date = date saisie
        if ($this->getStartDate() && !$this->getEndDate()) {
            $this->setStartDate($this->getEndDate());
        } elseif ($this->getEndDate() && !$this->getStartDate()) {
            $this->setEndDate($this->getStartDate());
        }
        // - si date deb apres date fin, inverser dates
        if ($this->getStartDate() > $this->getEndDate()) {
            $tmpDate = $this->getStartDate();
            $this->setStartDate($this->getEndDate());
            $this->setEndDate($tmpDate);
        }
    }
}