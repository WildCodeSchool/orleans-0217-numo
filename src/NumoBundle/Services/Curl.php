<?php

namespace NumoBundle\Services;


class Curl
{
    private $ch;


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
            ->setOpt(CURLOPT_POST, true);
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
            return false;
        } catch (\Exception $ex) {
            return false;
        }
        return json_decode($data, true);
    }

    public function setUrl(string $url)
    {
        $this->setOpt(CURLOPT_URL, $url);
        $this->setOpt(CURLOPT_POSTFIELDS, []);
        return $this;
    }

    public function close()
    {
        curl_reset($this->ch);
    }

}