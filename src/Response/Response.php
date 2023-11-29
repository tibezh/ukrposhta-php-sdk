<?php

declare(strict_types=1);

namespace Ukrposhta\Response;

class Response implements ResponseInterface
{
    /**
     * @param array<string|int, mixed|array<string, mixed>> $response
     */
    public function __construct(protected readonly array $response = [])
    {
    }

    public function getResponseData(): array
    {
        return $this->response;
    }
}
