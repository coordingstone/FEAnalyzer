<?php

namespace Console\views;
use Symfony\Component\Console\Output\OutputInterface;


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
        $output->writeln($message);
    }
}