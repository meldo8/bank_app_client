<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

class Client
{
    /**
     * @Serializer\Type("string")
     */
    public string $name;
    /**
     * @Serializer\Type("string")
     */
    public string $surname;
    /**
     * @Serializer\Type("string")
     */
    public string $personalNumber;
    /**
     * @Serializer\Type("string")
     */
    public string $accountNumber;
    /**
     * @Serializer\Type("string")
     */
    public string $balance;
}