<?php


namespace App\Command;

use App\Api\BankServerApi;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BalanceAccountCommand extends Command
{
    private const NAME = 'bank:balance';

    private BankServerApi $bankServerApi;


    public function __construct(BankServerApi $bankServerApi)
    {
        parent::__construct(self::NAME);

        $this->bankServerApi = $bankServerApi;
    }

    public function configure()
    {
        $this->addArgument('acc_source', InputArgument::REQUIRED, 'Source account number');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $client = $this->bankServerApi->getClient($input->getArgument('acc_source'));
        $count = count($client);
        if ($count > 1 || $count <= 0) {
            $io->error('There are some problems with your account, which we are trying to maintain. Please try again later.');
        }

        $io->success(sprintf('Your balance is: "%s".', $client[0]->balance));

        return 0;
    }
}