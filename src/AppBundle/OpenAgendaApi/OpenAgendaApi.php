<?php

// --- src/AppBundle/OpenAgendaApi/OpenAgendaApi.php ---

namespace AppBundle\OpenAgendaApi;



class OpenAgendaApi
{
    private $curl;
    private $getFileContents;
    private $aUid;
    private $token;
    private $errorCode = 0;
    private $error = '';

    // --- provisoirement en dur (a recuperer dans les params) ----------------------------
    private $publicKey = '1F6bZ8wy4X1IU7Myf7lJxcwwE5UdnBFo';
    private $secretKey = 'Tx8z8g8B0UQNMFRoKfIv370XaaDzc5nD';
    // ------------------------------------------------------------------------------------

    public function __construct($curl, $getFileContents)
    {
        $this->curl = $curl;
        $this->getFileContents = $getFileContents;
        $this->getAgendaUid();
    }

    public function getErrorCode()
    {
        return $this->errorCode();
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

    public function getSlug()
    {
        // --- inscrit en dur pour le moment ------------------------------------------------------------------------
        // --- devra etre lu dans les parametres de l'appli
//        return 'duri-wild';
        return 'paloaltours'; // pour tests
        // ----------------------------------------------------------------------------------------------------------
    }

    public function getAgendaUid()
    {
        if (!isset($this->aUid)) {
            $url = 'https://api.openagenda.com/v1/agendas/uid/'.$this->getSlug().'?key=' . $this->publicKey;
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

    private function getToken()
    {
        $this->curl
            ->seturl('https://api.openagenda.com/v1/requestAccessToken')
            ->setPost([
                'grant_type' => 'authorization_code',
                'code' => $secretKey,
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

    private function setToken($token)
    {
        $this->token = $token;
    }

    public function getEventList(array $options) : array
    {
        $url = 'https://api.openagenda.com/v1/agendas/'.$this->getAgendaUid().'/events?';
        foreach ($options as $opt => $value) {
            $url .= $opt . '=' . $value . '&';
        }
        $url .= 'key=' . $this->publicKey;
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






}
