<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Settlement;

/**
 *
 */
interface SettlementCollectionInterface
{

  /**
   * Adds Settlement object to the collection.
   *
   * @param SettlementInterface $settlement
   *   Settlement object to add.
   *
   * @return void
   */
  public function add(SettlementInterface $settlement): void;

  /**
   * Gets all Settlement collection in array.
   *
   * @return array<int, SettlementInterface>
   *   Simple array with Settlement objects.
   */
  public function all(): array;

}
