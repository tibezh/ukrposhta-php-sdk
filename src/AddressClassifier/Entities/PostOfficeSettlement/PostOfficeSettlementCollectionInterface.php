<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement;

/**
 *
 */
interface PostOfficeSettlementCollectionInterface
{

    /**
     * Adds Post Office Settlement object to the collection.
     *
     * @param PostOfficeSettlement $postOfficeSettlement
     *   Post Office Settlement object to add.
     *
     * @return void
     */
    public function add(PostOfficeSettlement $postOfficeSettlement): void;

    /**
     * Gets all Post Office Settlement collection in array.
     *
     * @return array<int, PostOfficeSettlement>
     *   Simple array with Post Office Settlement objects.
     */
    public function all(): array;

}
