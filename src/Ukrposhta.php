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

    /** Supported version. */
    public const string VERSION = '0.1.0';
    /** Base URL for requests. */
    public const string BASE_URL = 'https://www.ukrposhta.ua/';

    /**
     * Ukrposhta abstract class constructor.
     *
     * @param string|null $bearerEcom
     *   Ecom access token, uses to create deliveries, clients etc.
     * @param string|null $bearerStatusTracking
     *   Status Tracking access token, uses to check status tracking by barcode.
     * @param string|null $bearerCounterparty
     *   Counterparty token, uses for address classifier.
     * @param LoggerInterface|null $logger
     *   Logger for the requests.
     */
    public function __construct(
        protected readonly ?string $bearerEcom = null,
        protected readonly ?string $bearerStatusTracking = null,
        protected readonly ?string $bearerCounterparty = null,
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

}
