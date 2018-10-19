<?php
/**
 * Created by PhpStorm.
 * User: joelsvensson
 * Date: 2018-10-19
 * Time: 20:50
 */

namespace Console\views;
use Symfony\Component\Console\Output\OutputInterface;
use Console\models\RatesModel;
use Symfony\Component\Console\Helper\Table;


class OutputView extends BaseView
{
    private $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * @param OutputInterface $output
     * @param RatesModel[] $models
     */
    public function writeRateModelToTable(OutputInterface $output, $models) {

        if (!is_array($models) || count($models) < 0) {
            $this->writeError($output, 'Could not fetch rates');
        }
        $table = new Table($output);
        $table->setHeaders(array('Symbol', 'Rate', 'Rate 30 Days Ago', 'Rate Variation'));

        $rows = [];
        foreach($models as $rateModel) {
            $symbol = $rateModel->symbol;
            $rate = $rateModel->rate;
            $oldRate = $rateModel->oldRate;
            $rateVariation = $rateModel->rateVariation;

            $rows[] = [$rateModel->getSymbol(), $rateModel->getRate(), $rateModel->getOldRate(), $rateModel->getRateVariation()];

        }

        if (!$rows) {
            $rows[] = ['No ratemodels found'];
        }

        $table->setRows($rows);
        $table->render();



    }
}