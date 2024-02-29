<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\CourierArea;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 * Provides required methods for CourierArea entity.
 */
interface CourierAreaInterface extends EntityInterface
{

    /**
     * Gets courier area status.
     *
     * @return bool
     *   The true value is if the related post index includes the courier delivery service area, otherwise false.
     */
    public function isCourierArea(): bool;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): CourierAreaInterface;

}
