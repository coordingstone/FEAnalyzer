<?php namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Console\controllers\ValidateInput;


class BaseCommand extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $argument
     * @return bool
     */
    protected function isValidArgument($argument)
    {
        return ValidateInput::isValidStartDateString($argument);

    }
}