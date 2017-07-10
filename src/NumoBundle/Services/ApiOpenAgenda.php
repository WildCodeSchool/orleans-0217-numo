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
    private $aUid;
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
    }

    public function getError()
    {
        return $this->error;
    }

    private function setError(string $error)
    {
        $this->error = $error;
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
        if (!isset($this->aUid)) {
            $url = self::APIROOTURL . 'agendas/uid/' . $this->getAgendaSlug() . '?key=' . $this->getPublicKey();
            $this->getFileContents->setUrl($url);
            $data = $this->getFileContents->execute(true);
            if (false === $data) {
                $this->setErrorCode($this->getFileContents->getHttpCode());
                $this->setError('Lecture agenda : Erreur inconnue');
                return false;
            } else {
                $this->setAgendaUid($data['data']->uid);
            }
        }
        return $this->aUid;
    }

    private function setAgendaUid($aUid)
    {
        $this->aUid = $aUid;
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
        // --- version avec le ---------------------------------------------
        $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . '/events.json';
        if (count($options) > 0) {
            $url .= '?';
        }
        $i = 0;
        foreach ($options as $opt => $val) {
            $url .= "$opt=$val";
            $i++;
            if ($i < count($options)) {
                $url .= '&';
            }
        }
        $this->getFileContents->setUrl($url);
        $data = $this->getFileContents->execute();
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode());
            $this->setError('Lecture agenda : erreur inconnue');
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
        // --- version avec le json -----------------------------------
        $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . "/events.json?oaq[uids][]=$uid";
        $this->getFileContents->setUrl($url);
        $data = $this->getFileContents->execute();
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode());
            $this->setError('Lecture agenda : (' . $uid . ') ' . $this->getFileContents->getError());
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
            // --- version avec le json ------------------------------------------
            $event = $this->getEvent($uid);
            if ($event) {
                $eventList[] = $event;
            }
        }
        return $eventList;
    }

    private function initToken()
    {
        $this->curl
            ->seturl(self::APIROOTURL . 'requestAccessToken')
            ->setPost([
                'grant_type' => 'authorization_code',
                'code' => $this->getSecretKey(),
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('curl/token : ' . $this->curl->getError());
            return false;
        } else {
            $this->setToken($data['access_token']);
            return true;
        }
    }

    private function getToken()
    {
        return $this->token;
    }

    private function setToken($token)
    {
        $this->token = $token;
    }

    public function publishLocation($event)
    {
        $this->curl
            ->setUrl(self::APIROOTURL . 'locations')
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
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError($this->curl->getError());
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
        // --- ecriture de l'evenement ------------------------------------------------------------
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

        $this->curl->setUrl(self::APIROOTURL . 'events');
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
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('Erreur ecriture évènement : ' . $this->curl->getError());
            return false;
        }
        $event_uid = $data['uid'];
        // --- Referencement del'evenement dans l'agenda ------------------------------------------
        $refData = [
            'event_uid' => $event_uid,
        ];
        $this->curl->setUrl(self::APIROOTURL . 'agendas/' . $this->getAgendaUid() . '/events');
        $this->curl->setPost([
            'access_token' => $this->getToken(),
            'nonce' => $this->getRandom(),
            'data' => json_encode($refData)
        ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('Erreur référencement évènement : ' . $this->curl->getError());
            return false;
        }
        return ['eventUid' => $event_uid, 'locationUid' => $location_uid];
    }

    public function deleteEvent(Published $published)
    {
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode

        $uid = $published->getUid();
        $locationUid = $published->getLocationUid();
        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }
        // --- suppression evenement
        $this->curl->setUrl(self::APIROOTURL . "events/$uid");
        $this->curl->setOpt(CURLOPT_CUSTOMREQUEST, 'DELETE');
        $this->curl->setPost([
            'access_token' => $this->getToken(),
            'nonce' => $this->getRandom(),
        ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('Erreur suppression évènement : ' . $this->curl->getError());
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


// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // cette partie ne fonctionne pas, ou pas totalement (api non fonctionnelle)

//        // --- preparation des infos dates -------------------------------------------------
//        $eventData['locations'] = [[
//            'uid' => $published->getLocationUid(),
//            'dates' => []
//        ]];
//        $evtDates = $event->getEvtDates();
//        foreach ($evtDates as $evtDate) {
//            $eventData['locations'][0]['dates'][] = [
//                'date' => $evtDate->getEvtDate()->format('Y-m-d'),
//                'timeStart' => $evtDate->getTimeStart()->format('H:i'),
//                'timeEnd' => $evtDate->getTimeEnd()->format('H:i'),
//            ];
//        }
//
//        // --- preparation des infos lieu ---------------------------------------------------
//        $eventData['locations'][0]['pricingInfo'] = ['fr' => $event->getPricingInfo()->getPricing()];
//        $eventData['locations'][0]['ticketLink'] = '';
//        if ($event->getTicketLink()) {
//            $eventData['locations'][0]['ticketLink'] = $event->getFreeText();
//        }

// >>>>>>>>>>>>>>>>>> FIN DE ZONE PROVISOIRE >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }

        // --- ecriture de la mise a jour ----------------------------------------------------------
        $this->curl->setUrl(self::APIROOTURL . 'events/' . $published->getuid());
        $this->curl->setPost([
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
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('Erreur ecriture évènement : ' . $this->curl->getError());
            return false;
        }
        return $data;
    }

}