<?php

namespace Console\views;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;


class BaseView
{
    /**
     * @param OutputInterface $output
     * @param string $message
     */
    public function write(OutputInterface $output, $message) {
        $output->writeln($message);
    }

    /**
     * @param OutputInterface $output
     * @param string $message
     */
    public function writeError(OutputInterface $output, $message) {
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
}