<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

class TrackingStatusCollection implements TrackingStatusCollectionInterface
{
    /**
     * @var array<int, TrackingStatusInterface>
     */
    private array $items = [];

    private int $position = 0;

    /**
     * @param TrackingStatusInterface[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(TrackingStatusInterface $trackingStatus): void
    {
        $this->items[] = $trackingStatus;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): TrackingStatusInterface
    {
        return $this->items[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
