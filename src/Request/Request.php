<?php declare(strict_types=1);

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

/**
 *
 */
class Request implements RequestInterface, LoggerAwareInterface {

  /**
   * @var ClientInterface
   */
  protected ClientInterface $client;

  /**
   * @var array<string, mixed>
   */
  protected array $request = [];

  /**
   * @var string
   */
  protected string $access = '';

  /**
   * @var string
   */
  protected string $endpointUrl = '';

  /**
   * @var LoggerInterface
   */
  protected LoggerInterface $logger;

  /**
   * Request constructor.
   *
   * @param LoggerInterface|null $logger
   */
  public function __construct(?LoggerInterface $logger = null) {
    if ($logger !== null) {
      $this->setLogger($logger);
    } else {
      $this->setLogger(new NullLogger);
    }
    $this->setClient();
  }

  /**
   * {@inheritDoc}
   */
  public function setLogger(LoggerInterface $logger): void {
    $this->logger = $logger;
  }

  /**
   * {@inheritDoc}
   */
  public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface {
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

      $this->logger->debug("Response: {$body}" , $logger_context);

      if (200 === $response->getStatusCode()) {
        return new Response(response: (array) json_decode($body, true));
      }
      else {
        throw new InvalidResponseException(sprintf('Failure: %s response code.', $response->getStatusCode()));
      }
    }
    catch (TransferException $e) {
      $this->logger->alert($e->getMessage(), $logger_context);
      throw new RequestException($e->getMessage());
    }
  }

  /**
   * @return array<string, mixed>
   */
  protected function getRequestOptions(): array {
    return [
      'http_errors' => TRUE,
      'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer {$this->getAccess()}",
      ],
    ];
  }

  /**
   * Creates a single instance of the Guzzle client.
   */
  public function setClient(?ClientInterface $client = null): void {
    $this->client = $client ?? new Guzzle();
  }

  /**
   * {@inheritDoc}
   */
  public function setAccess(string $access): static {
    $this->access = $access;
    return $this;
  }

  /**
   * {@inheritDoc}
   */
  public function getAccess(): string {
    return $this->access;
  }

  /**
   * {@inheritDoc}
   */
  public function setRequest($request): static {
    $this->request = $request;
    return $this;
  }

  /**
   * {@inheritDoc}
   */
  public function getRequest(): array {
    return $this->request;
  }

  /**
   * {@inheritDoc}
   */
  public function setEndpointUrl(string $endpointUrl): static {
    $this->endpointUrl = $endpointUrl;
    return $this;
  }

  /**
   * {@inheritDoc}
   */
  public function getEndpointUrl(): string {
    return $this->endpointUrl;
  }

}
