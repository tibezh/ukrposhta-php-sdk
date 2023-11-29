<?php

declare(strict_types=1);

namespace Ukrposhta\Request;

use DateTime;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Response\Response;
use Ukrposhta\Response\ResponseInterface;

class Request implements RequestInterface, LoggerAwareInterface
{
    protected ClientInterface $client;

    /**
     * @var array<string, mixed>
     */
    protected array $request = [];

    protected string $access = '';

    protected string $endpointUrl = '';

    protected LoggerInterface $logger;

    /**
     * Request constructor.
     */
    public function __construct(LoggerInterface $logger = null)
    {
        if ($logger !== null) {
            $this->setLogger($logger);
        } else {
            $this->setLogger(new NullLogger());
        }
        $this->setClient();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface
    {
        $this->setAccess($access);
        $this->setRequest($request);
        $this->setEndpointUrl($endpointUrl);

        // Log request
        $date = new DateTime();
        $id = $date->format('YmdHisu');
        $logger_context = [
          'id' => $id,
          'endpointurl' => $this->getEndpointUrl(),
        ];
        $this->logger->info('Request to Ukrposhta API', $logger_context);

        $request_json = json_encode($this->getRequest());
        $this->logger->debug("Request: {$request_json}", $logger_context);

        try {
            $options = $this->getRequestOptions();

            if ('GET' === $method) {
                $options = array_merge($options, ['query' => $request]);
            }

            $response = $this->client->request(
                $method,
                $this->getEndpointUrl(),
                $options,
            );

            $body = (string) $response->getBody();

            $this->logger->info('Response from Ukrposhta API', $logger_context);

            $this->logger->debug("Response: {$body}", $logger_context);

            if (200 === $response->getStatusCode()) {
                return new Response(response: (array) json_decode($body, true));
            } else {
                throw new InvalidResponseException(sprintf('Failure: %s response code.', $response->getStatusCode()));
            }
        } catch (TransferException $e) {
            $this->logger->alert($e->getMessage(), $logger_context);
            throw new RequestException($e->getMessage());
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function getRequestOptions(): array
    {
        return [
          'http_errors' => true,
          'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->getAccess()}",
          ],
        ];
    }

    /**
     * Creates a single instance of the Guzzle client.
     */
    public function setClient(ClientInterface $client = null): void
    {
        $this->client = $client ?? new Guzzle();
    }

    public function setAccess(string $access): static
    {
        $this->access = $access;

        return $this;
    }

    public function getAccess(): string
    {
        return $this->access;
    }

    public function setRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function setEndpointUrl(string $endpointUrl): static
    {
        $this->endpointUrl = $endpointUrl;

        return $this;
    }

    public function getEndpointUrl(): string
    {
        return $this->endpointUrl;
    }
}
