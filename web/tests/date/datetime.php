<?php



class TimeTravel
{

    private $start;
    private $end;


    public function __construct(\DateTime $start, \DateTime $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     * @return TimeTravel
     */
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     * @return TimeTravel
     */
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

    public function getTravelInfo()
    {

        $d = (array) $this->getStart()->diff($this->getEnd());
        return 'Il y a '.$d['y'].' années, '.$d['m'].' mois, '.$d['d'].' jours, '.$d['h'].' heures, '.$d['i'].' minutes et '.$d['s'].' secondes entre les deux dates.';
    }

    public function findDate(string $interval)
    {
        $targetDate = clone $this->getStart();
        return $targetDate->modify($interval)->format('M d Y - h i');
    }

    public function backToFutureStepByStep(string $step)
    {
        $interval = new DateInterval($step);
        $targets = new DatePeriod($this->getEnd(), $interval, $this->getStart());

        var_dump($targets);

        return $targets;
    }

}
// --- première question (le blabla de l'écart de dates
$start = new DateTime();
$end = new DateTime('1985-12-31');
$travel1 = new timeTravel($start, $end);
echo 'Destination time : '.$end->format('d/m/Y h:i').'<br />';
echo 'Present time : '.$start->format('d/m/Y h:i').'<br />';
echo $travel1->getTravelInfo().'<br />';
echo '<br /><hr><br />';

// --- deuxième question
$travel2 = new timeTravel(new DateTime('1985-12-31'), new DateTime('1985-12-31'));
echo 'Destination time : '.$travel2->findDate('-1000000000 sec').'<br />';
echo 'Start time : '.$travel2->getStart()->format('M d y - h i').'<br />';
echo '<br /><hr><br />';


$returnTravel = new timeTravel(new \DateTime($travel->findDate('-1000000000 sec')), new DateTime('1985-12-31'));
$dates = $returnTravel->backToFutureStepByStep('P1M8D');
foreach ($dates as $d) {
    echo $d->format('Y-m-d').'<br />';
}
