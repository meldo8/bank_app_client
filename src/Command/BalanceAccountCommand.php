<?php


namespace App\Command;

use App\Api\BankServerApi;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BalanceAccountCommand extends Command
{
    private const NAME = 'bank:balance';

    private LoggerInterface $logger;
    private BankServerApi $bankServerApi;


    public function __construct(LoggerInterface $logger, BankServerApi $bankServerApi)
    {
        parent::__construct(self::NAME);

        $this->logger = $logger;
        $this->bankServerApi = $bankServerApi;
    }

    public function configure()
    {
        $this->addArgument('acc_source', InputArgument::REQUIRED, 'Source account number');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = $this->bankServerApi->getClient($input->getArgument('acc_source'));
        $this->logger->info(sprintf('Your balance is: "%s".', $client->balance));

        return 0;
    }
}