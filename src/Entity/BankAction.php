<?php
namespace App\Entity;

class BankAction
{
    public ?string $sourceAccountNumber = null;

    public ?string $targetAccountNumber = null;

    public string $amount;

    public string $action;
}
