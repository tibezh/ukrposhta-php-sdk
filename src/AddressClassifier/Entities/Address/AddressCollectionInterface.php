<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

/**
 *
 */
interface AddressCollectionInterface
{

  /**
   * Adds address object to the collection.
   *
   * @param AddressInterface $address
   *   Address object to add.
   *
   * @return void
   */
  public function add(AddressInterface $address): void;

  /**
   * Gets all address collection in array.
   *
   * @return array<int, AddressInterface>
   *   Simple array with Address objects.
   */
  public function all(): array;

}
