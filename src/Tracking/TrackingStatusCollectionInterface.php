<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

interface TrackingStatusCollectionInterface
{
    public function add(TrackingStatusInterface $trackingStatus): void;

    /**
     * @return array<int, TrackingStatusInterface>
     */
    public function all(): array;

    public function key(): int;

    public function rewind(): void;

    public function current(): TrackingStatusInterface;

    public function next(): void;

    public function valid(): bool;

    public function count(): int;
}
