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
    public const VERSION = '0.0.1';
    public const BASE_URL = 'https://www.ukrposhta.ua/';

    public function __construct(
        protected readonly ?string $bearerEcom = null,
        protected readonly ?string $bearerStatusTracking = null,
        protected readonly ?string $bearerCounterparty = null,
        protected bool $sandbox = false,
        protected ?LoggerInterface $logger = null,
    ) {
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    public function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Gets endpoints URL.
     */
    public function getEndpointUrl(): string
    {
        return self::BASE_URL;
    }

    public function isSandbox(): bool
    {
        return $this->sandbox;
    }
}
