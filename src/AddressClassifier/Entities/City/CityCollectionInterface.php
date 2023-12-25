<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

/**
 *
 */
interface CityCollectionInterface
{

  /**
   * Adds city object to the collection.
   *
   * @param CityInterface $city
   *   City object to add.
   *
   * @return void
   */
  public function add(CityInterface $city): void;

  /**
   * Gets all city collection in array.
   *
   * @return array<int, CityInterface>
   *   Simple array with City objects.
   */
  public function all(): array;

}
