<?php


namespace App\Command;


use App\Api\BankServerApi;
use App\Entity\BankAction;
use App\Enum\BankActionEnum;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DepositMoneyCommand extends Command
{
    private const NAME = 'bank:deposit';

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
        $this->addArgument('amount', InputArgument::REQUIRED, 'Amount to deposit');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $bankAction = new BankAction();
        $bankAction->action = BankActionEnum::DEPOSIT;
        $bankAction->sourceAccountNumber = $input->getArgument('acc_source');
        $bankAction->amount = $input->getArgument('amount');

        $this->bankServerApi->postAction($bankAction);

        $this->logger->info('Deposit of your money has been successfully finished');

        return 0;
    }
}