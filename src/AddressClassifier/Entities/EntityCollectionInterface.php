<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities;

/**
 * The base address classifier entity collection interface.
 */
interface EntityCollectionInterface
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

}
