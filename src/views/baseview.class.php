<?php

namespace Console\views;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;



class BaseView
{

    private $progressBar;

    /**
     * @param OutputInterface $output
     * @param string $message
     */
    public function writeError(OutputInterface $output, $message) {
        $this->stopProgressBar($output);
        $outputStyle = $this->getErrorFormatterStyle();
        $output->getFormatter()->setStyle('error', $outputStyle);
        $output->writeln('<error>'. $message . '</>');
    }

    /**
     * @return OutputFormatterStyle
     */
    protected function getErrorFormatterStyle(){
        $outputStyle = new OutputFormatterStyle('red', 'default', array('bold'));
        return $outputStyle;
    }

    /**
     * @return OutputFormatterStyle
     */
    protected function getNegativeRateVariationFormatterStyle(){
        $outputStyle = new OutputFormatterStyle('red', 'default', array('bold'));
        return $outputStyle;
    }

    /**
     * @return OutputFormatterStyle
     */
    protected function getPositiveRateVariationFormatterStyle(){
        $outputStyle = new OutputFormatterStyle('green', 'default', array('bold'));
        return $outputStyle;
    }

    protected function startProgressBar(OutputInterface $output){
        $this->progressBar = new ProgressBar($output);
        $this->progressBar->start();
    }

    protected function stopProgressBar(){
        if ($this->progressBar){
            $this->progressBar->finish();
        }
    }
}