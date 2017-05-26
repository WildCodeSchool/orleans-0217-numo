<?php

// --- src/AppBundle/OpenAgendaApi/Curl.php ---

namespace AppBundle\OpenAgendaApi;


class Curl
{
    private $ch;
    private $httpCode = 0;
    private $error = '';

    public function __construct(string $url='')
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
        return $this;
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

    public function setUrl(string $url)
    {
        $this->setOpt(CURLOPT_URL, $url);
        $this->setHttpCode(0);
        $this->setError('');
        $this->setOpt(CURLOPT_POSTFIELDS, []);
        return $this;
    }

    public function close()
    {
        curl_reset($this->ch);
    }

}