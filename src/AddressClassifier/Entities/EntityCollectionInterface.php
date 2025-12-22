<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities;

use Countable;
use IteratorAggregate;

/**
 * The base address classifier entity collection interface.
 *
 * @extends IteratorAggregate<int, EntityInterface>
 */
interface EntityCollectionInterface extends Countable, IteratorAggregate
{

    /**
     * Adds Entity object to the collection.
     *
     * @param EntityInterface $entity
     *   Entity object to add.
     *
     * @return void
     */
    public function add(EntityInterface $entity): void;

    /**
     * Gets all Entity collection in array.
     *
     * @return array<int, EntityInterface>
     *   Simple array with Entity objects.
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
