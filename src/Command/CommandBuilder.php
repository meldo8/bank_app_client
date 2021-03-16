<?php

namespace App\Command;

use App\Enum\BankActionEnum;

class CommandBuilder
{
    public function buildCommand(string $actionType, ?string $sourceAcc, ?string $targetAcc, ?string $amount): array
    {
      switch ($actionType) {
          case BankActionEnum::BALANCE:
              return [
                  'command' => 'bank:balance',
                  'acc_source' => $sourceAcc
              ];
          case BankActionEnum::TRANSFER:
              return [
                  'command' => 'bank:transfer',
                  'acc_source' => $sourceAcc,
                  'acc_target' => $targetAcc,
                  'amount' => $amount,
              ];
          case BankActionEnum::WITHDRAW:
              return [
                  'command' => 'bank:withdraw',
                  'acc_source' => $sourceAcc,
                  'amount' => $amount,
              ];
          case BankActionEnum::DEPOSIT:
              return [
                  'command' => 'bank:deposit',
                  'acc_source' => $sourceAcc,
                  'amount' => $amount,
              ];
      }

      throw new \Exception('There is no such bank action: ' . $actionType);
    }
}