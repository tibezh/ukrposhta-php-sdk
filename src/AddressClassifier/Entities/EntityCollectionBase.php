<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities;

/**
 *
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

}
