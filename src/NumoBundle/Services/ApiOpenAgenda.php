<?php

// --- src/NumoBundle/Services/ApiOpenAgenda.php ---

namespace NumoBundle\Services;



class ApiOpenAgenda
{
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
            $url = 'https://api.openagenda.com/v1/agendas/uid/'.$this->getAgendaSlug().'?key=' . $this->getPublicKey();
            $this->getFileContents->setUrl($url);
            $data = $this->getFileContents->execute();
            if (false === $data) {
                $this->setErrorCode($this->getFileContents->getHttpCode);
                $this->setError('Lecture agenda : Erreur inconnue');
                return false;
            } else {
                $this->setAgendaUid($data->uid);
            }
        }
        return $this->aUid;
    }

    private function setAgendaUid($aUid)
    {
        $this->aUid = $aUid;
    }

    private function initToken()
    {
        $this->curl
            ->seturl('https://api.openagenda.com/v1/requestAccessToken')
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

    public function publishLocation($nonce,$address)
    {
        $this->curl
            ->setUrl("https://api.openagenda.com/v1/locations")
            ->setPost([
                'access_token' => $this->getToken(),
                'nonce' => $nonce,
                'data' => json_encode([
                    'placename' => $address->getPlacename(),
                    'address' => $address->getAddress(),
                    'latitude' => $address->getLatitude(),
                    'longitude' => $address->getLongitude(),
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

    public function getEventList(array $options) : array
    {
        $url = 'https://api.openagenda.com/v1/agendas/'.$this->getAgendaUid().'/events?';
        foreach ($options as $opt => $value) {
            $url .= $opt . '=' . $value . '&';
        }
        $url .= 'key=' . $this->getPublicKey();
        $this->getFileContents->setUrl($url);
        $data = $this->getFileContents->execute();
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode);
            $this->setError('Lecture agenda : Erreur inconnue');
            return false;
        } else {
            return $data;
        }

    }

    public function getEvent(int $uid)
    {
        $url = "https://api.openagenda.com/v1/events/$uid?key=" . $this->getPublicKey();
        $this->getFileContents->setUrl($url);
        $data = $this->getFileContents->execute();
        if (false === $data) {
            $this->setErrorCode($this->getFileContents->getHttpCode());
            $this->setError('Lecture agenda : ('.$uid.') enregistrement non trouvé');
            return false;
        } else {
            return $data;
        }
    }







    public function publishEvent(Event $event)
    {
        $nonce = random(10000); // nombre aleatoire pour valider l'ecriture;
        // NOTE : en cas d'echec (return false) l'erreur (texte) est dans $this->error et le code http dans $this->errorCode
        // --- creation du token pour ecriture
        if (false === $this->initToken()) {
            return false; // l'initialisation du token a echoue
        } else {
            // ecriture de l'adresse
            $location_uid = $this->publishLocation($nonce, $event->address[0]);
            if (false === $location_uid) {
                return false; // l'ecriture de l'adresse a echouee
            } else {
                // --- ecriture de l'event
                $eventData = [
                    'lang' => 'fr',
                    'title' => ['fr' => $event->getTitle()],
                    'description' => ['fr' => $event->getDescription()],
                    'freeText' => ['fr' => $event->getFreeText()],
                    'tags' => ['fr' => $event->getTags()],
                    'image' => '', // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< a mettre a jour
//                    'publish' => false, // ne fonctionne pas
                    'thirdParties' => [],
                ];


                /////////////////////////////////////////// j'en suis là
                // il faut initialiser locations et dates
//                'locations' => [
//                    [
//                        'uid' => $location_uid,
//                        'dates' => [
//                            [
//                                'date' => '2017-06-01',
//                                'timeStart' => '18:00',
//                                'timeEnd' => '20:00',
//                            ],
//                            [
//                                'date' => '2017-06-02',
//                                'timeStart' => '19:00',
//                                'timeEnd' => '21:00',
//                            ],
//                        ],
//                        'pricingInfo' => ['fr' => 'Gratuit pour les moins de 10 ans'],
//                    ],
//
//                ],
//
                //if ... (ok)
                // enregistrement de l'event


            }
        }







    }


}
