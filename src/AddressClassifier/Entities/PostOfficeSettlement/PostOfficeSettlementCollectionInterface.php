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
     * @param PostOfficeSettlementInterface $postOfficeSettlement
     *   Post Office Settlement object to add.
     *
     * @return void
     */
    public function add(PostOfficeSettlementInterface $postOfficeSettlement): void;

    /**
     * Gets all Post Office Settlement collection in array.
     *
     * @return array<int, PostOfficeSettlementInterface>
     *   Simple array with Post Office Settlement objects.
     */
    public function all(): array;

}
