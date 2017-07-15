<?php

namespace NumoBundle\Services;

use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;
use NumoBundle\Entity\Published;


class ApiOpenAgenda
{
    const WEBROOTURL = 'https://openagenda.com/';
    const APIROOTURL = 'https://api.openagenda.com/v1/';

    private $curl;
    private $getFileContents;
    private $agendaSlug;
    private $agendaUid;
    private $publicKey;
    private $secretKey;
    private $token;
    private $errorCode = 0;
    private $error = '';

    public function __construct($curl, $getFileContents, $agendaSlug, $publicKey, $secretKey)
    {
        $this->curl = $curl;
        $this->getFileContents = $getFileContents;
        $this->agendaSlug = $agendaSlug;
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->getAgendaUid();
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    private function setErrorCode(int $code)
    {
        $this->errorCode = $code;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    private function setError(string $error)
    {
        $this->error = $error;
        return $this;
    }

    public function getAgendaSlug()
    {
        return $this->agendaSlug;
    }

    private function getPublicKey()
    {
        return $this->publicKey;
    }

    private function getSecretKey()
    {
        return $this->secretKey;
    }

    private function getRandom()
    {
        return random_int(1000, 999999);
    }

    public function getAgendaUid()
    {
        if (!isset($this->agendaUid)) {
            $url = self::APIROOTURL . 'agendas/uid/' . $this->getAgendaSlug() . '?key=' . $this->getPublicKey();
            $data = $this->getFileContents->execute($url, true);
            if (false === $data) {
                $this->setErrorCode($this->getFileContents->getHttpStatus());
                $this->setError('Lecture agenda : ' . $this->getFileContents->getHttpHeaders());
                return false;
            } else {
                $this->agendaUid = $data['data']->uid;
            }
        }
        return $this->agendaUid;
    }

    private function convertJson($event)
    {
        $newEvent = new OaEvent();
        $newEvent
            ->setId($event->uid)
            ->setLink($event->canonicalUrl)
            ->setTitle($event->title->fr)
            ->setPlacename($event->locationName)
            ->setAddress($event->address)
            ->setLatitude($event->latitude)
            ->setLongitude($event->longitude);
        if (isset($event->image)) {
            $newEvent->setImage($event->image);
        }
        if (isset($event->description)) {
            $newEvent->setDescription($event->description->fr);
        }
        if (isset($event->longDescription)) {
            $newEvent->setFreeText($event->longDescription->fr);
        }
        if (isset($event->keywords)) {
            $newEvent->setTags(implode(', ', $event->keywords->fr));
        }
        if (isset($event->registrationUrl)) {
            $newEvent->setTicketLink($event->registrationUrl);
        }
        if (isset($event->conditions)) {
            $newEvent->setPricingInfo($event->conditions->fr);
        }
        $oldDates = [];
        $newDates = [];
        $refDate = new \DateTime();
        foreach ($event->timings as $strDate) {
            // $strDate = 'AAAA-MM-DD HH:MM:SS' (en vrai '2017-06-01T12:00:00.000Z')
            // --- recuperation des dates / heures
            $curDate = new \DateTime($strDate->start, new \DateTimeZone('UTC'));
            $curEnd = new \DateTime($strDate->end, new \DateTimeZone('UTC'));
            // --- conversion fuseau horaire UTC -> ici
            $curDate->setTimezone(new \DateTimeZone('Europe/Paris'));
            $curEnd->setTimezone(new \DateTimeZone('Europe/Paris'));
            $evtDate = [
                'evtDate' => $curDate->format('Y-m-d'),
                'timeStart' => $curDate->format('H:i:s'),
                'timeEnd' => $curEnd->format('H:i:s'),
            ];
            if ($curDate->format('Y-m-d') < $refDate->format('Y-m-d')) {
                $oldDates[] = $evtDate;
            } else {
                $newDates[] = $evtDate;
            }
        }
        $newEvent->setOldDates($oldDates);
        $newEvent->setNewDates($newDates);
        return $newEvent;
    }

    public function getEventList(array $options = []): array
    {
        $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . '/events.json';
        $first = true;
        foreach ($options as $opt => $val) {
            $url .= ($first) ? '?' : '&';
            $url .= "$opt=$val";
            $first = false;
        }
        $data = $this->getFileContents->execute($url);
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpStatus());
            $this->setError('Lecture agenda : ' . $this->getFileContents->getHttpHeaders());
            return false;
        } else {
            // --- mise au bon format des donnees recuperees
            $eventList = [];
            $eventDateList = [];
            foreach ($data['data'] as $event) {
                $oneEvent = $this->convertJson($event);
                $eventList[] = $oneEvent;
                if ($oneEvent->getNewDates()) {
                    $date = \DateTime::createFromFormat('Y-m-d',$oneEvent->getNewDates()[0]['evtDate']);
                    $title = $oneEvent->getTitle();
                    $eventDateList[] = [$date->format('d'), $date->format('m'), $date->format('Y'), $title];
                }
            }
            return ['nbEvents' => $data['nbEvents'], 'eventList' => $eventList, 'eventDateList' => $eventDateList];
        }

    }

    public function getEvent(int $uid)
    {
        $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . "/events.json?oaq[uids][]=$uid";
        $data = $this->getFileContents->execute($url);
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpStatus());
            $this->setError('Lecture agenda : (' . $uid . ') ' . $this->getFileContents->getHttpHeaders());
            return false;
        } else {
            return $this->convertJson($data['data'][0]);
        }
    }

    public function getEvents(array $uids)
    {
        $eventList = [];
        // il faut autant de requetes que d'evenements a recuperer
        foreach ($uids as $uid) {
            $event = $this->getEvent($uid);
            if ($event) {
                $eventList[] = $event;
            }
        }
        return $eventList;
    }

    private function initToken()
    {
        $url = self::APIROOTURL . 'requestAccessToken';
        $this->curl
            ->seturl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'POST')
            ->setPost([
                'grant_type' => 'authorization_code',
                'code' => $this->getSecretKey(),
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError('curl/token : ' . $this->curl->getHttpHeaders());
            return false;
        } else {
            $this->token = $data['access_token'];
            return true;
        }
    }

    private function getToken()
    {
        return $this->token;
    }

    public function publishLocation($event)
    {
        $url = self::APIROOTURL . 'locations';
        $this->curl
            ->setUrl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'POST')
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $this->getRandom(),
                'data' => json_encode([
                    'placename' => $event->getPlacename(),
                    'address' => $event->getAddress(),
                    'latitude' => $event->getLatitude(),
                    'longitude' => $event->getLongitude(),
                ]),
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError($this->curl->getHttpHeaders());
            return false;
        } else {
            return $data['uid'];
        }
    }

    public function publishEvent(Event $event, string $uploadPath)
    {
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode

        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }
        // --- ecriture de l'adresse --------------------------------------------------------------
        $location_uid = $this->publishLocation($event);
        if (false === $location_uid) {
            return false; // l'ecriture de l'adresse a echouee
        }
        // --- preparation ecriture de l'evenement ------------------------------------------------
        $eventData = [
            'title' => ['fr' => $event->getTitle()],
            'description' => ['fr' => $event->getDescription()],
            'tags' => ['fr' => $event->getTags()->getName()],
            'locations' => [[
                'uid' => $location_uid,
                'dates' => [],
                'pricingInfo' => ['fr' => $event->getPricingInfo()->getPricing()],
            ]],
            'thirdParties' => [],
        ];
        if ($event->getFreeText()) {
            $eventData['freeText'] = ['fr' => $event->getFreeText()];
        }
        if ($event->getTicketLink()) {
            $eventData['locations'][0]['ticketLink'] = $event->getTicketLink();
        }
        $evtDates = $event->getEvtDates();
        foreach ($evtDates as $evtDate) {
            $eventData['locations'][0]['dates'][] = [
                'date' => $evtDate->getEvtDate()->format('Y-m-d'),
                'timeStart' => $evtDate->getTimeStart()->format('H:i'),
                'timeEnd' => $evtDate->getTimeEnd()->format('H:i'),
            ];
        }
        // --- preparation des infos image --------------------------------------------------------
        $image = null;
        if (!empty($event->getImage())) {
            $pathFile = realpath($uploadPath . '/' . $event->getImage());
            $urlFile = explode('/', $event->getImage());
            $image = new \CurlFile($pathFile, 'text/plain', end($urlFile));
        }

        // --- ecriture de l'evenement ------------------------------------------------------------
        $url = self::APIROOTURL . 'events';
        $this->curl
            ->setUrl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $postOptions = [
            'access_token' => $this->getToken(),
            'nonce' => $this->getRandom(),
            'data' => json_encode($eventData),
            'published' => false
        ];
        if ($image ) {
            $postOptions['image'] = $image;
        }
        $this->curl->setPost($postOptions);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError('Erreur ecriture évènement : ' . $this->curl->getHttpHeaders());
            return false;
        }
        $event_uid = $data['uid'];
        // --- Referencement del'evenement dans l'agenda ------------------------------------------
        $refData = [
            'event_uid' => $event_uid,
        ];
        $url = self::APIROOTURL . 'agendas/' . $this->getAgendaUid() . '/events';
        $this->curl
            ->setUrl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'POST')
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $this->getRandom(),
                'data' => json_encode($refData)
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError('Erreur référencement évènement : ' . $this->curl->getHttpHeaders());
            return false;
        }
        return ['eventUid' => $event_uid, 'locationUid' => $location_uid];
    }

    public function deleteEvent(Published $published)
    {
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode

        $locationUid = $published->getLocationUid();
        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }
        // --- suppression evenement
        $url = self::APIROOTURL . 'events/' . $published->getUid();
        $this->curl
            ->setUrl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'DELETE')
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $this->getRandom(),
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError('Erreur suppression évènement : ' . $this->curl->getHttpHeaders());
            return false;
        }
        return $data;
    }

    public function updateEvent(Event $event, Published $published, string $uploadPath)
    {
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode

        // --- preparation des infos "evenement" ---------------------------------------------------
        $eventData = [
            'title' => ['fr' => $event->getTitle()],
            'description' => ['fr' => $event->getDescription()],
            'tags' => ['fr' => $event->getTags()->getName()],
        ];
        $eventData['freeText'] = ['fr' => ''];
        if ($event->getFreeText()) {
            $eventData['freeText'] = ['fr' => $event->getFreeText()];
        }
        // --- preparation des infos image --------------------------------------------------------
        $image = null;
        if (!empty($event->getImage())) {
            // --- nouvelle image (en remplacement de celle dans published)
            $image = $event->getImage();
            $pathFile = realpath($uploadPath . '/' . $event->getImage());
            $urlFile = explode('/', $event->getImage());
            $image = new \CurlFile($pathFile, 'text/plain', end($urlFile));
        }

        // ------------------------------------------------------------------------------
        // --- il faudra gérer ici les infos dates et lieu lorsque l'API le permettra ---
        // ------------------------------------------------------------------------------

        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }
        // --- ecriture de la mise a jour ---------------------------------------------------------
        $url = self::APIROOTURL . 'events/' . $published->getuid();
        $this->curl
            ->setUrl($url)
            ->setOpt(CURLOPT_CUSTOMREQUEST, 'POST')
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $this->getRandom(),
                'data' => json_encode($eventData),
            ]);
        $postOptions = [
            'access_token' => $this->getToken(),
            'nonce' => $this->getRandom(),
            'data' => json_encode($eventData),
        ];
        if ($image) {
            $postOptions['image'] = $image;
        }
        $this->curl->setPost($postOptions);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpStatus());
            $this->setError('Erreur ecriture évènement : ' . $this->curl->getHttpHeaders());
            return false;
        }
        return $data;
    }

}