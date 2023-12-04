<?php

declare(strict_types=1);

namespace Ukrposhta\Request;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Response\ResponseInterface;

/**
 * Request interface for Ukrposhta integration.
 */
interface RequestInterface
{

    /**
     * Request constructor.
     *
     * @param ?LoggerInterface $logger
     *   The logger for the Request object, leave null to use NullLogger.
     */
    public function __construct(LoggerInterface $logger = null);

    /**
     * Main method to send requests.
     *
     * @param string $access
     *   Access key.
     * @param string $method
     *   Request method.
     * @param string $endpointUrl
     *   Request endpoint.
     * @param array<string, mixed> $request
     *   An associative array that contains data for a request
     *
     * @return ResponseInterface
     *   Response data.
     *
     * @throws InvalidResponseException
     * @throws RequestException
     * @throws GuzzleException
     */
    public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface;

    /**
     * Applies access token.
     *
     * @param string $access
     *   The access token to apply.
     *
     * @return $this
     */
    public function setAccess(string $access): static;

    /**
     * Gets access string from the object.
     *
     * @return string
     *   The access token string.
     */
    public function getAccess(): string;

    /**
     * Applies request data to the object.
     *
     * @param array<string, mixed> $request
     *   The associative array of request data to apply.
     *
     * @return $this
     */
    public function setRequest(array $request): static;

    /**
     * Gets request data.
     *
     * @return array<string, mixed>
     */
    public function getRequest(): array;

    /**
     * Applies endpoint URL.
     *
     * @param string $endpointUrl
     *   The endpoints URL to apply.
     *
     * @return $this
     */
    public function setEndpointUrl(string $endpointUrl): static;

    /**
     * Gets endpoints URL.
     *
     * @return string
     */
    public function getEndpointUrl(): string;

}
