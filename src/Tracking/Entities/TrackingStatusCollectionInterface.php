<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking\Entities;

use Countable;
use Iterator;

/**
 * Tracking status collection interface.
 *
 * @extends Iterator<int, TrackingStatusInterface>
 */
interface TrackingStatusCollectionInterface extends Countable, Iterator
{

    /**
     * Adds tracking status object to the collection.
     *
     * @param TrackingStatusInterface $trackingStatus
     *   Tracking Status object to add.
     *
     * @return void
     */
    public function add(TrackingStatusInterface $trackingStatus): void;

    /**
     * Gets all tracking status collection in array.
     *
     * @return array<int, TrackingStatusInterface>
     *   Simple array with Tracking Status object.
     */
    public function all(): array;

    /**
     * Checks if the collection is empty.
     *
     * @return bool
     *   True if the collection has no items, false otherwise.
     */
    public function isEmpty(): bool;

}
