<?php
/**
 * Created by PhpStorm.
 * User: joelsvensson
 * Date: 2018-10-19
 * Time: 20:30
 */

namespace Console\utility;


class RatesVariationCalculatorUtility
{
    /**
     * @param $rate
     * @param $oldRate
     * @return float
     */
    static function calculateRateVariation($rate, $oldRate) {
        $rateVariation = $rate - $oldRate;
        $rateVariation = $rateVariation / $oldRate;
        $rateVariation = $rateVariation * 100;

        return $rateVariation;
    }
}