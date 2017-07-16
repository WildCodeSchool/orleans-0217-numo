<?php

namespace NumoBundle\Services;


class Curl
{
    private $ch;
    private $errorCode;
    private $error;

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param mixed $errorCode
     * @return Curl
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     * @return Curl
     */
    public function setError($error)
    {
        $this->error = $error;
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
            ->setErrorCode(0)
            ->setError('');
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
            $this->setErrorCode($httpException->getStatusCode());
            $this->setError($httpException->getHeaders());
            return false;
        } catch (\Exception $ex) {
            $this->setErrorCode(0);
            $this->setError($ex->getMessage());
            return false;
        }
        return json_decode($data, true);
    }

    public function setUrl(string $url)
    {
        $this->setOpt(CURLOPT_URL, $url);
        $this->setErrorCode(0);
        $this->setError('');
        $this->setOpt(CURLOPT_POSTFIELDS, []);
        return $this;
    }

    public function close()
    {
        curl_reset($this->ch);
    }

}