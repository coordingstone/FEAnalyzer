<?php

namespace Console\views;
use Symfony\Component\Console\Output\OutputInterface;
use Console\models\RatesModel;
use Symfony\Component\Console\Helper\Table;


class OutputView extends BaseView
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct($output)
    {
        $this->output = $output;
        $this->startProgressBar($this->output);
    }

    /**
     * @param OutputInterface $output
     * @param RatesModel[] $models
     */
    public function writeRateModelsToTable(OutputInterface $output, $models) {

        $this->stopProgressBar();

        $negativeRateOutputStyle = $this->getNegativeRateVariationFormatterStyle();
        $positiveRateOutputStyle = $this->getPositiveRateVariationFormatterStyle();

        $output->getFormatter()->setStyle('negative', $negativeRateOutputStyle);
        $output->getFormatter()->setStyle('positive', $positiveRateOutputStyle);


        if (!is_array($models) || count($models) < 0) {
            $this->writeError($output, 'Could not fetch rates');
        }
        $table = new Table($output);
        $table->setHeaders(array('Symbol', 'Rate', 'Rate 30 Days Ago', 'Rate Variation'));

        $rows = [];
        foreach($models as $rateModel) {

            $symbol = $rateModel->getSymbol();
            $rate = $rateModel->getRate();
            $oldRate = $rateModel->getOldRate();
            $rateVariation = $rateModel->getRateVariation();

            if ($rateVariation < 0) {
                $rows[] = [$symbol, $rate, $oldRate, '<negative>'. $rateVariation . '</>'];
            } else {
                $rows[] = [$symbol, $rate, $oldRate, '<positive>'. $rateVariation . '</>'];
            }





        }

        if (!$rows) {
            $rows[] = ['No ratemodels found'];
        }

        $table->setRows($rows);
        $table->render();



    }
}