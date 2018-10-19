<?php

namespace Console\controllers;
use Console\controllers\RestClient;
use Console\models\RatesModel;
use Console\utility\RatesVariationCalculatorUtility;

class AnalyzeRatesController
{

    /**
     * @param $argument
     * @return RatesModel[]
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getRatesModels($argument)
    {
        $restClient = new RestClient();
        $ratesArray = $this->getRatesFromArgument($restClient, $argument);
        $oldRatesArray = $this->getRatesFrom30DaysAgo($restClient, $argument);
        $oldRatesArray = explode(',' , json_encode($oldRatesArray));

        $ratesModelsArray = $this->createRatesModelArray($ratesArray);
        $ratesModelsArray = $this->joinOldRatesArrayAndPassToRatedModelArray($ratesModelsArray, $oldRatesArray);
        $ratesModelsArray = $this->sortArrayAfterRateVariation($ratesModelsArray);

        return $ratesModelsArray;
    }

    /**
     * @param RatesModel[] $ratesModelsArray
     * @return mixed
     */
    private function sortArrayAfterRateVariation($ratesModelsArray) {
        usort($ratesModelsArray,function($first,$second){
            return $first->rateVariation < $second->rateVariation;
        });
        return $ratesModelsArray;
    }

    /**
     * @param RatesModel[] $ratesModelsArray
     * @param $oldRatesArray
     * @return RatesModel[]
     */
    private function joinOldRatesArrayAndPassToRatedModelArray($ratesModelsArray, $oldRatesArray){
        foreach($ratesModelsArray as $rateModel) {
            foreach($oldRatesArray as $key => $item) {

                $itemArray = explode(':', $item);
                $symbols = $this->getSymbolValue('"', '"', $itemArray[0]);
                $oldRate = $itemArray[1];

                if ($rateModel->symbol === $symbols[0]) {
                    $rateModel->oldRate = $oldRate;
                    $rateModel->rateVariation = RatesVariationCalculatorUtility::calculateRateVariation($rateModel->rate, $rateModel->oldRate);
                }
            }
        }
        return $ratesModelsArray;
    }

    /**
     * @param $ratesArray
     * @return RatesModel[]
     */
    private function createRatesModelArray($ratesArray){
        $ratesModelArray = array();
        $ratesArray = explode(',', json_encode($ratesArray));
        foreach($ratesArray as $key => $item) {
            $itemArray = explode(':', $item);
            $ratesModel = new RatesModel();
            $symbols = $this->getSymbolValue('"', '"', $itemArray[0]);
            $ratesModel->symbol = $symbols[0];
            $ratesModel->rate = $itemArray[1];
            array_push($ratesModelArray, $ratesModel);
        }

        return $ratesModelArray;
    }

    /**
     * @param $start
     * @param $end
     * @param $str
     * @return mixed
     */
    function getSymbolValue($start, $end, $str){
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_]*)$end/";
        preg_match_all($regex, $str, $matches);
        return $matches[1];
    }

    /**
     * @param RestClient $restClient
     * @param string $argument
     * @return RatesModel[]
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    private function getRatesFrom30DaysAgo($restClient, $argument){

        if ($argument === '' || $argument === null) {
            $argument = date('Y-m-d', strtotime('-30 days'));
        } else {
            $argument = date('Y-m-d',strtotime("-30 days",strtotime($argument)));
        }

        $ratesArray = $restClient->getRatesWithAllSymbols($argument);

        return $ratesArray;
    }

    /**
     * @param RestClient $restClient
     * @param string $argument
     * @return RatesModel[]
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    private function getRatesFromArgument($restClient, $argument){

        if ($argument === '' || $argument === null) {
            $argument = date('Y-m-d');
        }

        $ratesArray = $restClient->getRatesWithAllSymbols($argument);


        return $ratesArray;
    }

}