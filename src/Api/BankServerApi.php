<?php


namespace App\Api;


use App\Entity\BankAction;
use App\Entity\Client;
use App\Entity\ClientResponse;

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
            ['Content-Type' => 'application/json'],
            $this->apiClient->serializeRequestBody($bankAction)
        );
    }

    /**
     * @return Client[]
     */
    public function getClient(string $accountNumber): array
    {
        $response = $this->apiClient->sendRequest(
            'GET',
            sprintf('api/clients/?accountNumber=%s', $accountNumber),
            ['Accept' => 'application/json'],
            null
        );

        return $this->apiClient->deserializeResponse($response, sprintf('array<%s>', Client::class));
    }

    /**
     * @return Client[]
     */
    public function getClients(): array
    {
        $response = $this->apiClient->sendRequest(
            'GET',
            'api/clients',
            ['Accept' => 'application/json'],
            null
        );

        return $this->apiClient->deserializeResponse($response, sprintf('array<%s>', Client::class));
    }
}
