<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\House;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 * Provides required methods for House entity.
 */
interface HouseInterface extends EntityInterface
{

    /**
     * Gets address post code.
     *
     * @return int
     *   Post code of the address.
     */
    public function getPostCode(): int;

    /**
     * Gets address house number.
     *
     * @return string
     *   House number of the address.
     */
    public function getHouseNumber(): string;

    /**
     * Gets an associative array version of the Address.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): HouseInterface;

}
