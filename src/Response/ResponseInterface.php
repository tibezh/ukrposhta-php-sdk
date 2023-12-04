<?php

declare(strict_types=1);

namespace Ukrposhta\Response;

/**
 * Response interface for Ukrposhta integration.
 */
interface ResponseInterface
{

    /**
     * Gets a response object.
     *
     * @return array<string|int, string|mixed|array<string, mixed>>
     */
    public function getResponseData(): array;

}
