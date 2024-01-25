<?php

declare(strict_types=1);

namespace Ukrposhta;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * The main abstract class to Ukrposhta connection.
 */
abstract class Ukrposhta implements LoggerAwareInterface
{

    /** @var string Supported version. */
    public const VERSION = '0.0.1';
    /** @var string Base URL for requests. */
    public const BASE_URL = 'https://www.ukrposhta.ua/';

    /**
     * Ukrposhta abstract class constructor.
     *
     * @param string|null $bearerEcom
     *   Ecom access token, uses to create deliveries, clients etc.
     * @param string|null $bearerStatusTracking
     *   Status Tracking access token, uses to check status tracking by barcode.
     * @param string|null $bearerCounterparty
     *   Counterparty token, uses for address classifier.
     * @param bool $sandbox
     *   Flag to use sandbox, false by default.
     * @param array<string, mixed> $options
     *   Associative array with additional options to the library.
     * @param LoggerInterface|null $logger
     *   Logger for the requests.
     */
    public function __construct(
        protected readonly ?string $bearerEcom = null,
        protected readonly ?string $bearerStatusTracking = null,
        protected readonly ?string $bearerCounterparty = null,
        protected readonly bool $sandbox = false,
        protected readonly array $options = [],
        protected ?LoggerInterface $logger = null,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * Gets logger object.
     *
     * @return LoggerInterface|null
     *   The logger object if exists, otherwise null.
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Gets supported Ukrposhta API version.
     *
     * The version needs to build an endpoints URL.
     *
     * @return string
     *   The version for endpoint URL.
     */
    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Gets endpoint URL.
     *
     * @return string
     *   The endpoint URL.
     */
    public function getEndpointUrl(): string
    {
        return self::BASE_URL;
    }

    /**
     * Flag which indicates sandbox uses.
     *
     * @return bool
     *   The true if sandbox uses, otherwise false.
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * Gets additional options.
     *
     * @return array<string, mixed>
     *    Assoc array with the additional options of the library.
     */
    public function getOptions(): array
    {
        return $this->options;
    }

}
