<?php

namespace App\Api;

use App\Serializer\BankSerializerBuilder;
use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BankServerApiClient
{
    private HttpClientInterface $client;

    private LoggerInterface $logger;

    private Serializer $serializer;

    public function __construct(
        HttpClientInterface $httpBankClient,
        LoggerInterface $logger
    ) {
        $this->client = $httpBankClient;
        $this->logger = $logger;
        $this->serializer = BankSerializerBuilder::build();
    }

    public function sendRequest(
        string $method,
        string $uri,
        array $headers = [],
        string $body = null
    ): ResponseInterface {
        $response = $this->client->request(
            $method,
            $uri,
            [
                'headers' => $headers,
                'body' => $body,
            ]
        );
        if ($response->getStatusCode() >= 400) {
            $message = sprintf(
                'Request to uri: "%s" has failed (status code: "%s") with message: "%s"',
                $uri,
                $response->getStatusCode(),
                $response->getContent(false)
            );
            $this->logger->error($message);

            throw new \Exception($message);
        }

        return $response;
    }

    public function serializeRequestBody(object $body): string
    {
        return $this->serializer->serialize($body, 'json');
    }

    public function deserializeResponse(ResponseInterface $response, string $class, string $format = 'json')
    {
        return $this->serializer->deserialize($response->getContent(false), $class, $format);
    }
}
