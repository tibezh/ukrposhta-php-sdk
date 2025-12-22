<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities;

use ArrayIterator;
use Traversable;

/**
 * Base abstract class for entity collections.
 */
abstract class EntityCollectionBase implements EntityCollectionInterface
{

    /**
     * Simple array of Entity objects.
     *
     * @var array<int, EntityInterface>
     */
    protected array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(EntityInterface $entity): void
    {
        $this->items[] = $entity;
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
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * {@inheritDoc}
     *
     * @return Traversable<int, EntityInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

}
