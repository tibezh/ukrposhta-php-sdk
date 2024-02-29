<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities;

/**
 * The base address classifier entity interface.
 */
interface EntityInterface
{

    /**
     * Gets Entity object from response entry.
     *
     * @param array<string|mixed> $entry
     *   Entry from a response.
     *
     * @return EntityInterface
     *   Entity object.
     */
    public static function fromResponseEntry(array $entry): EntityInterface;

}
