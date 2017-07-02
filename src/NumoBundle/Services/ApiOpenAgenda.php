<?php

namespace NumoBundle\Services;

use NumoBundle\Entity\Event;
use NumoBundle\Entity\OaEvent;


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

    private function convertApi($event)
    {
        $newEvent = new OaEvent;
        $newEvent
            ->setId($event->uid);
        $link = self::WEBROOTURL . $this->getAgendaSlug() . '/event/' . end(explode('/', $event->link));
        $newEvent
            ->setLink($link)
            ->setImage($event->image)
            ->setTitle($event->title->fr)
            ->setDescription($event->description->fr)
            ->setFreeText($event->freetext->fr)
            ->setTags($event->tags->fr)
            ->setPlacename($event->locations[0]->placename)
            ->setAddress($event->locations[0]->address)
            ->setLatitude($event->locations[0]->latitude)
            ->setLongitude($event->locations[0]->longitude)
            ->setTicketLink($event->locations[0]->ticketLink)
            ->setPricingInfo($event->locations[0]->pricingInfo->fr);
        $oldDates = [];
        $newDates = [];
        $dateRef = new \DateTime();
        foreach ($event->location[0]->dates as $evtD) {
            $oaDates[] = ['evtDate' => $evtD->date, 'timeStart' => $evtd->timeStart, 'timeEnd' => $evtd->timeEnd]; // AAAA-MM-DD HH:MM:SS
        }
        $newEvent->setEvtDates($oaDates);
        $newEvent->setEvtDates($oaDates);
        $dateRef = new \DateTime();
        $dateRef->format('Y-m-d');
        foreach ($oaDates as $oaDate) {
            // $evtD = AAAA-MM-DD HH:MM:SS
            $evtDate = ['evtDate' => substr($evtD->start, 0, 10), 'timeStart' => substr($evtD->start, 11, 8), 'timeEnd' => substr($evtD->end, 11, 8)];
            if ($evtDate['evtDate'] < $dateRef->format('Y-m-d')) {
                $oldDates[] = $evtDate;
            } else {
                $newDates[] = $evtDate;
            }
        }
        $newEvent->setOldDates($oldDates);
        $newEvent->setNewDates($newDates);
        return $newEvent;
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
        if (isset($event->image)) $newEvent->setImage($event->image);
        if (isset($event->description)) $newEvent->setDescription($event->description->fr);
        if (isset($event->longDescription)) $newEvent->setFreeText($event->longDescription->fr);
        if (isset($event->keywords)) $newEvent->setTags(implode(', ', $event->keywords->fr));
        if (isset($event->registrationUrl)) $newEvent->setTicketLink($event->registrationUrl);
        if (isset($event->conditions)) $newEvent->setPricingInfo($event->conditions->fr);
        $oldDates = [];
        $newDates = [];
        $dateRef = new \DateTime();
        foreach ($event->timings as $evtD) {
            // $evtD = AAAA-MM-DD HH:MM:SS
            $evtDate = ['evtDate' => substr($evtD->start, 0, 10), 'timeStart' => substr($evtD->start, 11, 8), 'timeEnd' => substr($evtD->end, 11, 8)];
            if ($evtDate['evtDate'] < $dateRef->format('Y-m-d')) {
                $oldDates[] = $evtDate;
            } else {
                $newDates[] = $evtDate;
            }
        }
        $newEvent->setOldDates($oldDates);
        $newEvent->setNewDates($newDates);
        return $newEvent;
    }

    public function getEventList(array $options = [], bool $api = false): array
    {
        if ($api) {
            // --- version avec l'api -------------------------------------------
            $url = self::APIROOTURL . 'agendas/' . $this->getAgendaUid() . '/events?key=' . $this->getPublicKey() . '&';
        } else {
            // --- version avec le json (sans l'api) -----------------------------
            $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . '/events.json';
            if (count($options) > 0) {
                $url .= '?';
            }
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
        $data = $this->getFileContents->execute($api);
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode());
            $this->setError('Lecture agenda : erreur inconnue');
            return false;
        } else {
            // --- mise au bon format des donnees recuperees
            $eventList = [];
            $eventDateList = [];
            if ($api) {
                foreach ($data['data'] as $event) {
                    $oneEvent = $this->convertApi($event);
                    $eventList[] = $oneEvent;
                }
            } else {
                foreach ($data['data'] as $event) {
                    $oneEvent = $this->convertJson($event);
                    $eventList[] = $oneEvent;
                    if ($oneEvent->getNewDates()) {
                        $date = $oneEvent->getNewDates()[0];
                        $title = $oneEvent->getTitle();
                        $eventDateList[] = [
                            substr($date['evtDate'], 8, 2),
                            substr($date['evtDate'], 5, 2),
                            substr($date['evtDate'], 0, 4),
                            $title
                        ];
                    }
                }
            }
            return ['nbEvents' => $data['nbEvents'], 'eventList' => $eventList, 'eventDateList' => $eventDateList];
        }

    }

    public function getEvent(int $uid, $api = false)
    {
        if ($api) {
            // --- version avec l'api -------------------------------------------
            $url = self::APIROOTURL . "events/$uid?key=" . $this->getPublicKey();
        } else {
            // --- version avec le json -----------------------------------
            $url = self::WEBROOTURL . 'agendas/' . $this->getAgendaUid() . "/events.json?oaq[uids][]=$uid";
        }
        $this->getFileContents->setUrl($url);
        $data = $this->getFileContents->execute($api);
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode());
            $this->setError('Lecture agenda : (' . $uid . ') ' . $this->getFileContents->getError());
            return false;
        } else {
            if ($api) {
                return $this->convertApi($data['data']);
            } else {
                return $this->convertJson($data['data'][0]);
            }
        }
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
            $this->setErrorCode($this->curl->getHttpCode);
            $this->setError('curl/token : ' . $this->curl->getError);
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

    public function publishLocation($nonce, $event)
    {
        $this->curl
            ->setUrl(self::APIROOTURL . 'locations')
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $nonce,
                'data' => json_encode([
                    'placename' => $event->getPlacename(),
                    'address' => $event->getAddress(),
                    'latitude' => $event->getLatitude(),
                    'longitude' => $event->getLongitude(),
                ]),
            ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpCode);
            $this->setError($this->curl->getError);
            return false;
        } else {
            return $data['uid'];
        }
    }

    public function publishEvent(Event $event)
    {
        $nonce = random_int(1, 10000); // nombre aleatoire pour valider l'ecriture;
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode

        // --- creation du token pour ecriture ----------------------------------------------------
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        }

        // --- ecriture de l'adresse --------------------------------------------------------------
        $location_uid = $this->publishLocation($nonce, $event);
        if (false === $location_uid) {
            return false; // l'ecriture de l'adresse a echouee
        }

        // --- ecriture de l'evenement ------------------------------------------------------------
        $eventData = [
            'title' => ['fr' => $event->getTitle()],
            'description' => ['fr' => $event->getDescription()],
            'tags' => ['fr' => $event->getTags()->getName()],
            'image' => $event->getImage(),
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
            $eventData['locations'][0]['ticketLink'] = $event->getFreeText();
        }
        $evtDates = $event->getEvtDates();
        foreach ($evtDates as $evtDate) {
            $eventData['locations'][0]['dates'][] = [
                'date' => $evtDate->getEvtDate()->format('Y-m-d'),
                'timeStart' => $evtDate->getTimeStart()->format('H:i'),
                'timeEnd' => $evtDate->getTimeEnd()->format('H:i'),
            ];
        }
        $this->curl->setUrl(self::APIROOTURL . 'events');
        $this->curl->setPost([
            'access_token' => $this->getToken(),
            'nonce' => $nonce + 1,
            'data' => json_encode($eventData),
            'published' => false
        ]);
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
            'nonce' => $nonce + 2,
            'data' => json_encode($refData)
        ]);
        $data = $this->curl->execute();
        if (false === $data) {
            $this->setErrorCode($this->curl->getHttpCode());
            $this->setError('Erreur référencement évènement : ' . $this->curl->getError());
            return false;
        }
        return $event_uid;
    }


}