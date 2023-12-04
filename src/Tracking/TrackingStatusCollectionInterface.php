<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 * Tracking status collection interface.
 */
interface TrackingStatusCollectionInterface
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
     * Gets the iterator position.
     *
     * @return int
     */
    public function key(): int;

    /**
     * Resets iterator position.
     *
     * @return void
     */
    public function rewind(): void;

    /**
     * Gets current Tracking Status object according to iterator position.
     *
     * @return TrackingStatusInterface
     */
    public function current(): TrackingStatusInterface;

    /**
     * Increase the internal iterator for 1.
     *
     * @return void
     */
    public function next(): void;

    /**
     * Checks if the current position of iterator is valid.
     *
     * @return bool
     */
    public function valid(): bool;

    /**
     * Gets count of Tracking Status items in the collection.
     *
     * @return int
     */
    public function count(): int;

}
