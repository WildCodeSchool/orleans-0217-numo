<?php

namespace NumoBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetFileContents
{
    private $httpStatus;
    private $httpHeaders;

    private function setHttpStatus(int $code)
    {
        $this->httpStatus = $code;
        return $this;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    private function setHttpHeaders(string $httpHeaders)
    {
        $this->httpHeaders = $httpHeaders;
        return $this;
    }

    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }

    public function execute(string $url, bool $api = false)
    {
        try {
            $info = file_get_contents($url);
        } catch (\HttpException $httpException) {
            $this->setHttpStatus($httpException->getStatusCode());
            $this->setHttpHeaders($httpException->getHeaders());
            return false;
        }
        $data = json_decode($info);
        if ($api) {
            // --- version api ----------
            if (false === $data->success) {
                $this->setHttpStatus($data->code);
                $this->setHttpHeaders('GetFileContents : ' . $data->message);
                return false;
            } else {
                // -1 car on ne recupere pas le nombre d'evenements (2eme parametre)
                return ['data' => $data->data, 'nbEvents' => -1];
            }
        } else {
            // --- version json -------
            if (isset($data->message)) {
                $this->setHttpStatus(0);
                $this->setHttpHeaders('GetFileContents : ' . $data->message);
                return false;
            } else {
                return ['data' => $data->events, 'nbEvents' => $data->total];
            }
        }
    }

}