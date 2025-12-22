<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\DeliveryArea;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 * Required methods for the Delivery Area entity.
 */
interface DeliveryAreaInterface extends EntityInterface
{

    /**
     * Gets Delivery Area City ID.
     *
     * @return int
     *   The City ID of the Delivery Area.
     */
    public function getCityId(): int;

    /**
     * Gets Delivery Area Postcode.
     *
     * @return int
     *   The Postcode of the Delivery Area.
     */
    public function getPostCode(): int;

    /**
     * Gets an associative array version of the Delivery Area.
     *
     * @return array<string, mixed>
     *   Array version of the object.
     */
    public function toArray(): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): DeliveryAreaInterface;

}
