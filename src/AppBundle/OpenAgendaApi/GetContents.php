<?php

// --- src/AppBundle/OpenAgendaApi/GetContents.php ---

namespace AppBundle\OpenAgendaApi;


class GetContents
{
    private $url;
    private $httpCode = 0;
    private $error = '';

    public function setUrl(string $url)
    {
        $this->url = $url;
        $this->setHttpCode(0);
        $this->setError('');
        return $this;
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
        if (!isset($this->url) || $this->url == '') {
            $this->setHttpCode(404);
            $this->setError('FileGetContents : URL non définie');
            return false;
        } else {
            $info = file_get_contents($this->url);
            if (false === $info) {
                $this->setErrorCode(999);
                $this->setError('FileGetContents : Erreur inconnue');
                return false;
            } else {
                $data = json_decode($info);
                if (false === $data->success) {
                    $this->setErrorCode($data->code);
                    $this->setError('FileGetContents : ' . $data->message);
                    return false;
                }
                else {
                    return $data->data;
                }

            }
        }
    }

}