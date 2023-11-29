<?php

declare(strict_types=1);

namespace Ukrposhta\Request;

use Psr\Log\LoggerInterface;
use Ukrposhta\Response\ResponseInterface;

interface RequestInterface
{
    public function __construct(LoggerInterface $logger = null);

    /**
     * @param array<string, mixed> $request
     */
    public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface;

    public function setAccess(string $access): static;

    public function getAccess(): string;

    /**
     * @param array<string, mixed> $request
     */
    public function setRequest(array $request): static;

    /**
     * @return array<string, mixed>
     */
    public function getRequest(): array;

    public function setEndpointUrl(string $endpointUrl): static;

    public function getEndpointUrl(): string;
}
