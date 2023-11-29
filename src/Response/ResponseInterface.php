<?php

declare(strict_types=1);

namespace Ukrposhta\Response;

interface ResponseInterface
{
    /**
     * Response object.
     *
     * @return array<string|int, string|mixed|array<string, mixed>>
     */
    public function getResponseData(): array;
}
