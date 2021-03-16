<?php

namespace App\Command;

use App\Api\BankServerApi;
use App\Enum\BankActionEnum;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MimicCustomerExperienceCommand extends Command
{
    private const NAME = 'bank:mimic';

    private BankServerApi $bankServerApi;
    private CommandBuilder $commandBuilder;
    private Application $app;

    public function __construct(BankServerApi $bankServerApi, CommandBuilder $commandBuilder)
    {
        parent::__construct(self::NAME);

        $this->bankServerApi = $bankServerApi;
        $this->commandBuilder = $commandBuilder;

        $this->app = new Application();
        $this->app->setAutoExit(false);
        $this->app->addCommands([
            new TransferMoneyCommand($this->bankServerApi),
            new BalanceAccountCommand($this->bankServerApi),
            new DepositMoneyCommand($this->bankServerApi),
            new WithdrawMoneyCommand($this->bankServerApi),
        ]);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $targetAcc = null;
        $amount = null;
        $epochs = 1000;

        $clients = $this->bankServerApi->getClients();
        $client = $clients[array_rand($clients)];
        $sourceAcc = $client->accountNumber;

        $io->writeln(sprintf('Start of bank UX mimic for client: %s %s %s', $client->name, $client->surname, $client->personalNumber));

        while ($epochs >= 0) {
            $epochs -= 1;
            $bankAction = BankActionEnum::getAllBankActions()[array_rand(BankActionEnum::getAllBankActions())];

            $io->writeln(sprintf('Command action to trigger: %s', $bankAction));
            if (in_array($bankAction, [BankActionEnum::TRANSFER])) {
                $targetAcc = $clients[array_rand($clients)]->accountNumber;
            }

            if (in_array($bankAction, [BankActionEnum::TRANSFER, BankActionEnum::DEPOSIT, BankActionEnum::WITHDRAW])) {
                $amount = (string)rand(0, 200);
            }

            $command = $this->commandBuilder->buildCommand($bankAction, $sourceAcc, $targetAcc, $amount);
            $output = $this->runCommand($command);

            $io->writeln(sprintf('Command output: %s', $output));
            $io->writeln(sprintf('%s epochs left', $epochs));

            sleep(5);
        }

        return 0;
    }

    private function runCommand(array $command): string
    {
        $output = new BufferedOutput();
        $this->app->run(new ArrayInput($command), $output);

        return $output->fetch();
    }
}
