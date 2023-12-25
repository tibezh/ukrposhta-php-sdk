<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

/**
 * Region collection interface.
 */
interface RegionCollectionInterface
{

  /**
   * Adds region object to the collection.
   *
   * @param RegionInterface $region
   *   Region object to add.
   *
   * @return void
   */
  public function add(RegionInterface $region): void;

  /**
   * Gets all region collection in array.
   *
   * @return array<int, RegionInterface>
   *   Simple array with Region objects.
   */
  public function all(): array;

}
