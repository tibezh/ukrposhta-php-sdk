<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking\Entities;

/**
 * Provided collection of Tracking Status object.
 */
class TrackingStatusCollection implements TrackingStatusCollectionInterface
{

    /**
     * Simple array of Tracking Status objects.
     *
     * @var array<int, TrackingStatusInterface>
     */
    private array $items = [];

    /**
     * Current position of iterator.
     *
     * @var int
     */
    private int $position = 0;

    /**
     * TrackingStatusCollection constructor.
     *
     * @param TrackingStatusInterface[] $items
     *   Simple array of Tracking Status objects to apply.
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function add(TrackingStatusInterface $trackingStatus): void
    {
        $this->items[] = $trackingStatus;
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function current(): TrackingStatusInterface
    {
        return $this->items[$this->position];
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->items);
    }

}
