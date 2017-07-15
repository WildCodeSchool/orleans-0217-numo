<?php

namespace NumoBundle\Services;


class Curl
{
    private $ch;
    private $httpStatus;
    private $httpHeaders;

    /**
     * @return mixed
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     * @param mixed $httpStatus
     * @return Curl
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    /**
     * @param mixed $httpHeaders
     * @return Curl
     */
    public function setHttpHeaders($httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
        return $this;
    }


    public function __construct(string $url='')
    {
        if (!isset($this->ch)) {
            $this->ch = curl_init($url);
        } else {
            curl_reset($this->ch);
            $this->setOpt(CURLOPT_URL, $url);
        }
        $this
            ->setOpt(CURLOPT_RETURNTRANSFER, true)
            ->setOpt(CURLOPT_POST, true)
            ->setHttpStatus(0)
            ->setHttpHeaders('');
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

    public function execute()
    {
        try {
            $data = curl_exec($this->ch);
        } catch (\HttpException $httpException) {
            $this->setHttpStatus($httpException->getStatusCode());
            $this->setHttpHeaders($httpException->getHeaders());
            return false;
        }
        return json_decode($data, true);
    }

    public function setUrl(string $url)
    {
        $this->setOpt(CURLOPT_URL, $url);
        $this->setHttpStatus(0);
        $this->setHttpHeaders('');
        $this->setOpt(CURLOPT_POSTFIELDS, []);
        return $this;
    }

    public function close()
    {
        curl_reset($this->ch);
    }

}