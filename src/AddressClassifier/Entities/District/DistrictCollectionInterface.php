<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

/**
 *
 */
interface DistrictCollectionInterface
{

  /**
   * Adds district object to the collection.
   *
   * @param DistrictInterface $district
   *   District object to add.
   *
   * @return void
   */
  public function add(DistrictInterface $district): void;

  /**
   * Gets all district collection in array.
   *
   * @return array<int, DistrictInterface>
   *   Simple array with District objects.
   */
  public function all(): array;

}
