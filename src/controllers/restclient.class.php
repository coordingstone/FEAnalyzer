<?php

namespace Console\controllers;
use Console\utility\ConstantsUtility;

class RestClient
{

    /**
     * @param  string $argument
     * @return mixed
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getRatesWithAllSymbols($argument){
        $response = \Httpful\Request::get(ConstantsUtility::HTTP_GET_REQUEST_BASE_URL . $argument . '?access_key=' . ConstantsUtility::ACCESS_KEY)->send();

        return $response->body->rates;

    }

}