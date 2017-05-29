<?php



class Curl
{
    private $ch;
    private $httpCode = 0;
    private $error = '';

    public function __construct(string $url)
    {
        if (!isset($this->ch)) {
            $this->ch = curl_init($url);
        } else {
            curl_reset($this->ch);
            $this->setOpt(CURLOPT_URL, $url);
        }
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        $this->setOpt(CURLOPT_CUSTOMREQUEST, 'POST');
        $this->setOpt(CURLOPT_POST, true);
    }

    public function setOpt($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
        return $this;
    }

    public function setPost(array $postFields)
    {
        $this->setOpt(CURLOPT_POSTFIELDS, $postFields);
    }

    private function getInfo($option)
    {
        return curl_getinfo($this->ch, $option);
    }

    private function setHttpCode($code)
    {
        $this->httpCode = $code;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    private function setError(string $error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function execute()
    {
        $data = curl_exec($this->ch);
        $this->setHttpCode($this->getInfo(CURLINFO_HTTP_CODE));
        if ($this->getHttpCode() == 200) {
            $this->setError('');
            return json_decode($data, true);
        } else {
            // $this->setError($data); // a tester
            $this->setError(curl_error($this->ch));
            return false;
        }
    }

    public function resetUrl(string $url)
    {
        $this->setOpt(CURLOPT_URL, $url);
        $this->setHttpCode(0);
        $this->setError('');
        $this->setOpt(CURLOPT_POSTFIELDS, []);
    }

    public function close()
    {
        curl_reset($this->ch);
    }


}



// ***** tests de lecture des agendas *****

$agenda_uid = '91057368';
$agenda_slug = 'duri-wild';
$publicKey = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';
$secretKey = 'Tx8z8g8B0UQNMFRoKfIv370XaaDzc5nD';

$addr = [
    'adr1' => '106 rue Saint Nicolas',
    'adr2' => '',
    'codpost' => '45470',
    'ville' => 'LOURY',
];
$placename = 'Bureaux';

// --- Recuperation des coordonnees GPS
$address = urlencode(utf8_encode(implode(' ', $addr)));
$geocoder = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";
$coord = json_decode(file_get_contents($geocoder));
if ($coord->status == 'OK') {
    $address = $coord->results[0]->formatted_address;
    $lat = $coord->results[0]->geometry->location->lat;
    $lng = $coord->results[0]->geometry->location->lng;

    echo 'Adresse détectée : <span style="color:blue;">' . $address . '</span><br />';
    echo '&nbsp;&nbsp;&nbsp;Lattitude : <span style="color:blue;">' . $lat . '</span><br />';
    echo '&nbsp;&nbsp;&nbsp;Longitude : <span style="color:blue;">' . $lng . '</span><br />';


    // --- recuperation d'un token pour ecriture ------------------------------------
    $ch = new Curl('https://api.openagenda.com/v1/requestAccessToken');
    $ch->setPost([
        'grant_type' => 'authorization_code',
        'code' => $secretKey
    ]);
    $data = $ch->execute();
    if (false === $data) {
        echo 'erreur recup token : '.$ch->getHttpCode().' - '.$ch->getError().'<br />';
    } else {
        $accessToken = $data['access_token'];
        $timer = $data['expires_in'];

        echo '<hr><b>Récupération token pour écriture</b> : Var dump de l\'objet token récupéré';
        var_dump($data);
        echo "Token : <b>$accessToken</b>, durée de vie : <b>$timer secondes</b>.";
        echo '<hr>';

        $nonce = rand(1000, 9999);

        // --- ecriture de l'adresse --------------------------------------------------
        $ch->resetUrl("https://api.openagenda.com/v1/locations");
        $ch->setPost([
            'access_token' => $accessToken,
            'nonce' => $nonce,
            'data' => json_encode([
                'placename' => $placename,
                'address' => $address,
                'latitude' => $lat,
                'longitude' => $lng,
            ]),
        ]);
        $data = $ch->execute();
        if (false === $data) {
            echo 'Erreur ecriture adresse : '.$ch->getHttpCode().' - '.$ch->getError().'<br />';
        } else {
            $location_uid = $data['uid'];

            echo '<hr><b>Retour écriture adresse</b> : Var dump de l\'objet récupéré';
            var_dump($data);
            echo "UID lieu : <b>$location_uid</b><br />";
            echo '<hr>';


            // --- ecriture event ---------------------------------------------------------
            $eventData = [
//                'lang' => 'fr',
                'title' => ['fr' => 'La dance des canards V2'],
                'description' => ['fr' => 'blablabla et plus'],
                'freeText' => ['fr' => 'Cet événement fait partie des tests de l\'API'],
                'tags' => ['fr' => 'test, api, canard'],
                'image' => '',
                'publish' => 0,
                'locations' => [
                    [
                        'uid' => $location_uid,
                        'dates' => [
                            [
                                'date' => '2017-06-01',
                                'timeStart' => '18:00',
                                'timeEnd' => '20:00',
                            ],
                            [
                                'date' => '2017-06-02',
                                'timeStart' => '19:00',
                                'timeEnd' => '21:00',
                            ],
                        ],
                        'pricingInfo' => ['fr' => 'Gratuit pour les moins de 10 ans'],
                    ],

                ],
                'thirdParties' => [],
            ];

            $ch->resetUrl("https://api.openagenda.com/v1/events");
            $ch->setPost([
                'access_token' => $accessToken,
                'nonce' => $nonce + 1,
                'data' => json_encode($eventData)
            ]);
            $data = $ch->execute();
            if (false === $data) {
                echo 'Erreur ecriture évènement : ' . $ch->getHttpCode() . ' - ' . $ch->getError() . '<br />';
            } else {
                $event_uid = $data['uid'];

                echo '<hr><b>Retour écriture évènement</b> : Var dump de l\'objet récupéré';
                var_dump($data);
                echo "UID évènement : <b>$event_uid</b><br />";
                echo '<hr>';


                // --- Referencement del'evenement dans l'agenda ----------------------
                $refData = [
                    'event_uid' => $event_uid,
                    'category' => 'Categtest',
                ];
                $ch->resetUrl("https://api.openagenda.com/v1/agendas/$agenda_uid/events");
                $ch->setPost([
                    'access_token' => $accessToken,
                    'nonce' => $nonce + 2,
                    'data' => json_encode($refData)
                ]);
                $data = $ch->execute();
                if (false === $data) {
                    echo 'Erreur référencement évènement : ' . $ch->getHttpCode() . ' - ' . $ch->getError() . '<br />';
                } else {
                    echo '<hr><b>Retour référencement évènement</b> : Var dump de l\'objet récupéré';
                    var_dump($data);
                    echo '<hr>';


                    // --- relecture objet cree
                    $requete = "https://api.openagenda.com/v1/events/$event_uid?&key=$publicKey";
                    $data = json_decode(file_get_contents($requete));

                    echo '<hr><b>Relecture évènement</b> : Var dump de l\'objet récupéré';
                    var_dump($data);
                    echo '<hr>';


                }
            }
        }
    }
}