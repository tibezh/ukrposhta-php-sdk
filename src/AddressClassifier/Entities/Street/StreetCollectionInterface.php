<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

/**
 *
 */
interface StreetCollectionInterface
{

  /**
   * Adds street object to the collection.
   *
   * @param StreetInterface $street
   *   Street object to add.
   *
   * @return void
   */
  public function add(StreetInterface $street): void;

  /**
   * Gets all street collection in array.
   *
   * @return array<int, StreetInterface>
   *   Simple array with Street objects.
   */
  public function all(): array;

}
