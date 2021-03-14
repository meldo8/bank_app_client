<?php


namespace App\Api;


use App\Entity\BankAction;
use App\Entity\Client;

class BankServerApi
{
    private BankServerApiClient $apiClient;

    public function __construct(BankServerApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function postAction(BankAction $bankAction): void
    {
        $this->apiClient->sendRequest(
        'POST',
            'api/bank_actions',
            [],
            $this->apiClient->serializeRequestBody($bankAction)
        );
    }

    public function getClient(string $accountNumber): Client
    {
        $response = $this->apiClient->sendRequest(
            'GET',
            sprintf('api/clients?account_number=%', $accountNumber),
            [],
            null
        );

        return $this->apiClient->deserializeResponse($response, Client::class);
    }
}