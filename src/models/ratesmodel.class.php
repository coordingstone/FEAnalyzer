<?php

namespace Console\models;


class RatesModel
{
    /**
     * @var string
     */
    public $symbol;

    /**
     * @var float
     */
    public $rate;

    /**
     * @var float
     */
    public $oldRate;

    /**
     * Init to 100 because we want to avoid division by 0
     * @var float
     */
    public $rateVariation = 100;

    /**
     * @return string
     */
    public function getSymbol() {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getRate() {
        return sprintf("%.3f", $this->rate);
    }

    /**
     * @return string
     */
    public function getOldRate() {
        return sprintf("%.3f", $this->oldRate);
    }

    /**
     * @return string
     */
    public function getRateVariation() {
        return number_format($this->rateVariation, 3) .'%';
    }

}