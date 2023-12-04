<?php

declare(strict_types=1);

namespace Ukrposhta\Response;

/**
 * Response class.
 */
class Response implements ResponseInterface
{
    /**
     * Defines $response object property.
     *
     * @param array<string|int, mixed|array<string, mixed>> $response
     *   The response to apply.
     */
    public function __construct(protected readonly array $response = [])
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getResponseData(): array
    {
        return $this->response;
    }

}
