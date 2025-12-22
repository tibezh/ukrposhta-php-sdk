<?php

declare(strict_types=1);

namespace Ukrposhta\Request;

use DateTime;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Response\Response;
use Ukrposhta\Response\ResponseInterface;

/**
 * The main class to send requests.
 */
class Request implements RequestInterface, LoggerAwareInterface
{

    /** @var int Default maximum number of retry attempts. */
    public const DEFAULT_MAX_RETRIES = 3;

    /** @var int Default base delay between retries in milliseconds. */
    public const DEFAULT_RETRY_DELAY_MS = 100;

    /**
     * Related client object for requests.
     *
     * @see Request::setRequest()
     * @see Request::getRequest()
     *
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * An associative array that contains data for a request.
     *
     * @see Request::setRequest()
     * @see Request::getRequest()
     *
     * @var array<string, mixed>
     */
    protected array $request = [];

    /**
     * Access key for a request.
     *
     * @see Request::setAccess()
     * @see Request::getAccess()
     *
     * @var string
     */
    protected string $access = '';

    /**
     * Endpoint for request.
     *
     * @see Request::getEndpointUrl()
     * @see Request::setEndpointUrl()
     *
     * @var string
     */
    protected string $endpointUrl = '';

    /**
     * Related logger object.
     *
     * @see Request::setLogger()
     * @see Request::getLogger()
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Maximum number of retry attempts.
     *
     * @var int
     */
    protected int $maxRetries;

    /**
     * Base delay between retries in milliseconds.
     *
     * @var int
     */
    protected int $retryDelayMs;

    /**
     * {@inheritDoc}
     *
     * @param int $maxRetries
     *   Maximum number of retry attempts for transient errors.
     * @param int $retryDelayMs
     *   Base delay between retries in milliseconds (uses exponential backoff).
     */
    public function __construct(
        LoggerInterface $logger = null,
        int $maxRetries = self::DEFAULT_MAX_RETRIES,
        int $retryDelayMs = self::DEFAULT_RETRY_DELAY_MS
    ) {
        if ($logger !== null) {
            $this->setLogger($logger);
        } else {
            $this->setLogger(new NullLogger());
        }
        $this->maxRetries = $maxRetries;
        $this->retryDelayMs = $retryDelayMs;
        $this->setClient();
    }

    /**
     * {@inheritDoc}
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface
    {
        $this->setAccess($access);
        $this->setRequest($request);
        $this->setEndpointUrl($endpointUrl);

        // Log request.
        $date = new DateTime();
        $id = $date->format('YmdHisu');
        $loggerContext = [
          'id' => $id,
          'endpointurl' => $this->getEndpointUrl(),
        ];
        $this->logger->info('Request to Ukrposhta API', $loggerContext);

        $requestJson = json_encode($this->getRequest());
        $this->logger->debug("Request: {$requestJson}", $loggerContext);

        $options = $this->getRequestOptions();
        if ('GET' === $method) {
            $options = array_merge($options, ['query' => $request]);
        }

        $lastException = null;
        for ($attempt = 0; $attempt <= $this->maxRetries; $attempt++) {
            try {
                if ($attempt > 0) {
                    $delayMs = $this->calculateRetryDelay($attempt);
                    $this->logger->info(
                        sprintf('Retry attempt %d/%d after %dms delay', $attempt, $this->maxRetries, $delayMs),
                        $loggerContext
                    );
                    usleep($delayMs * 1000);
                }

                $response = $this->client->request(
                    $method,
                    $this->getEndpointUrl(),
                    $options,
                );

                $body = (string) $response->getBody();

                $this->logger->info('Response from Ukrposhta API', $loggerContext);
                $this->logger->debug("Response: {$body}", $loggerContext);

                // Guzzle with http_errors => true handles 4xx/5xx responses.
                $decoded = json_decode($body, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new InvalidResponseException(
                        sprintf('Invalid JSON response: %s', json_last_error_msg())
                    );
                }

                return new Response(response: (array) $decoded);
            } catch (ConnectException $e) {
                // Connection errors are retryable.
                $lastException = $e;
                $this->logger->warning(
                    sprintf('Connection error (attempt %d/%d): %s', $attempt + 1, $this->maxRetries + 1, $e->getMessage()),
                    $loggerContext
                );
            } catch (TransferException $e) {
                // Other transfer exceptions are not retryable.
                $this->logger->alert($e->getMessage(), $loggerContext);
                throw new RequestException($e->getMessage());
            }
        }

        // All retries exhausted.
        $this->logger->alert(
            sprintf('All %d retry attempts exhausted', $this->maxRetries + 1),
            $loggerContext
        );
        throw new RequestException(
            $lastException?->getMessage() ?? 'Request failed after all retry attempts'
        );
    }

    /**
     * Calculates retry delay using exponential backoff.
     *
     * @param int $attempt
     *   Current retry attempt number (1-based).
     *
     * @return int
     *   Delay in milliseconds.
     */
    protected function calculateRetryDelay(int $attempt): int
    {
        // Exponential backoff: delay * 2^(attempt-1)
        // With jitter: add random 0-50% to avoid thundering herd.
        $baseDelay = $this->retryDelayMs * (2 ** ($attempt - 1));
        $jitter = (int) ($baseDelay * (mt_rand(0, 50) / 100));
        return $baseDelay + $jitter;
    }

    /**
     * Returns default request options.
     *
     * @return array<string, mixed>
     *   Associative array with default request options.
     */
    protected function getRequestOptions(): array
    {
        return [
          'http_errors' => true,
          'headers' => [
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$this->getAccess()}",
          ],
        ];
    }

    /**
     * Creates a single instance of the Guzzle client.
     *
     * @param ClientInterface|null $client
     *   The client object for requests, leave null to use Guzzle by default.
     *
     * @return void
     */
    public function setClient(ClientInterface $client = null): void
    {
        $this->client = $client ?? new Guzzle();
    }

    /**
     * {@inheritDoc}
     */
    public function setAccess(string $access): static
    {
        $this->access = $access;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAccess(): string
    {
        return $this->access;
    }

    /**
     * {@inheritDoc}
     */
    public function setRequest(array $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * {@inheritDoc}
     */
    public function setEndpointUrl(string $endpointUrl): static
    {
        $this->endpointUrl = $endpointUrl;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpointUrl(): string
    {
        return $this->endpointUrl;
    }

}
