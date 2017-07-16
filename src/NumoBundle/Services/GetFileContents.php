<?php

namespace NumoBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetFileContents
{
    private $errorCode;
    private $error;

    private function setErrorCode(int $code)
    {
        $this->errorCode = $code;
        return $this;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    private function setError(string $error)
    {
        $this->error = $error;
        return $this;
    }

    public function getError()
    {
        return $this->error;
    }

    public function execute(string $url, bool $api = false)
    {
        try {
            $info = file_get_contents($url);
        } catch (\HttpException $httpException) {
            $this->setErrorCode($httpException->getStatusCode());
            $this->setError($httpException->getHeaders());
            return false;
        } catch (\exception $ex) {
            $this->setErrorCode(0);
            $this->setError($ex->getMessage());
            return false;
        }
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