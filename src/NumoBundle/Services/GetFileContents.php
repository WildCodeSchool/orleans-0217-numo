<?php

namespace NumoBundle\Services;

class GetFileContents
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

    public function execute(bool $api)
    {
        if (!isset($this->url) || $this->url == '') {
            $this->setHttpCode(404);
            $this->setError('GetFileContents : URL non définie');
            return false;
        } else {
            $info = file_get_contents($this->url);
            if (false === $info) {
                $this->setErrorCode(999);
                $this->setError('GetFileContents : Erreur inconnue');
                return false;
            } else {
                $data = json_decode($info);
                if ($api) {
                    // --- version api ----------
                    if (false === $data->success) {
                        $this->setErrorCode($data->code);
                        $this->setError('GetFileContents : ' . $data->message);
                        return false;
                    } else {
                        // -1 car on ne recupere pas le nombre d'evenements (2eme parametre)
                        return ['data' => $data->data, 'nbEvents' => -1];
                    }
                } else {
                    // --- version json -------
                    if (isset($data->message)) {
                        $this->setErrorCode(0);
                        $this->setError('GetFileContents : ' . $data->message);
                        return false;
                    } else {
                        return ['data' => $data->events, 'nbEvents' => $data->total];
                    }
                }

            }
        }
    }

}