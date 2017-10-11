<?php

namespace NumoBundle\Services;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GetFileContents
{

    public function execute(string $url, bool $api = false)
    {
        try {
            $info = file_get_contents($url);
        } catch (\HttpException $httpException) {
            return false;
        } catch (\exception $ex) {
            return false;
        }
        $data = json_decode($info);
        if ($api) {
            // --- version api ----------
            if (false === $data->success) {
                return false;
            } else {
                // -1 car on ne recupere pas le nombre d'evenements (2eme parametre)
                return ['data' => $data->data, 'nbEvents' => -1];
            }
        } else {
            // --- version json -------
            if (isset($data->message)) {
                return false;
            } else {
                return ['data' => $data->events, 'nbEvents' => $data->total];
            }
        }
    }

}