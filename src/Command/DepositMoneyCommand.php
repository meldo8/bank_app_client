<?php

namespace App\Command;

use App\Api\BankServerApi;
use App\Entity\BankAction;
use App\Enum\BankActionEnum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DepositMoneyCommand extends Command
{
    private const NAME = 'bank:deposit';

    private BankServerApi $bankServerApi;

    public function __construct(BankServerApi $bankServerApi)
    {
        parent::__construct(self::NAME);

        $this->bankServerApi = $bankServerApi;
    }

    public function configure()
    {
        $this->addArgument('acc_source', InputArgument::REQUIRED, 'Source account number');
        $this->addArgument('amount', InputArgument::REQUIRED, 'Amount to deposit');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $bankAction = new BankAction();
        $bankAction->action = BankActionEnum::DEPOSIT;
        $bankAction->sourceAccountNumber = $input->getArgument('acc_source');
        $bankAction->amount = $input->getArgument('amount');

        $this->bankServerApi->postAction($bankAction);

        $io->success('Deposit of your money has been successfully ordered');

        return 0;
    }
}