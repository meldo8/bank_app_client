<?php

namespace App\Enum;

class BankActionEnum
{
    public const DEPOSIT = 'D';
    public const WITHDRAW = 'W';
    public const TRANSFER = 'T';
    public const BALANCE = 'B';

    public static function getAllBankActions(): array
    {
        return [self::DEPOSIT, self::WITHDRAW, self::TRANSFER, self::BALANCE];
    }
}
