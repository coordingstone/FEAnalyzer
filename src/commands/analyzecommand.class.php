<?php namespace Console;
use Console\views\OutputView;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Console\controllers\AnalyzeRatesController;

class AnalyzeCommand extends BaseCommand
{

    /**
     * @var OutputInterface $outputInterface
     */
    private $outputInterface;

    /**
     * @var OutputView
     */
    private $outputView;

    public function configure()
    {
        $this -> setName('analyze')
            -> setDescription('Analyze rate variation between two dates from http://fixer.io/.')
            -> setHelp('Enter a start date or leave empty to use todays date.')
            -> addArgument('startDateString', InputArgument::OPTIONAL, 'The start date that will be used to query fixer.io.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->outputInterface = $output;
        $this->outputView = new OutputView($output);
        $argument = $input->getArgument('startDateString');
        $this->isValidArgument($argument ) == true ? $this->getRatesVariationModels($argument) : $this->outputView->writeError($output, 'Please fill in a valid start date,' . ' Format: ' .  'YYYY-MM-DD');
    }

    /**
     * @param string $argument
     */
    private function getRatesVariationModels($argument) {
        $arController = new AnalyzeRatesController();
        try {
            $rates = $arController->getRatesVariationModels($argument);
            $this->outputView->writeRateModelToTable($this->outputInterface, $rates);
        } catch (\Httpful\Exception\ConnectionErrorException $exception) {
            $this->outputView->writeError($this->outputInterface, 'Failed to get rates with error code: ' . $exception->getMessage());
        }




    }




}