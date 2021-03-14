<?php


namespace App\Serializer;


use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;

class BankSerializerBuilder
{
    public static function build()
    {
        return (SerializerBuilder::create())
            ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
            ->build()
        ;
    }
}