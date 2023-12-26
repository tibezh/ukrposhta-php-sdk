<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\NearestPostOffice;

/**
 *
 */
interface NearestPostOfficeCollectionInterface
{

  /**
   * Adds nearest post office object to the collection.
   *
   * @param NearestPostOffice $nearestPostOffice
   *   Nearest Post Office object to add.
   *
   * @return void
   */
  public function add(NearestPostOffice $nearestPostOffice): void;

  /**
   * Gets all nearest post office collection in array.
   *
   * @return array<int, NearestPostOffice>
   *   Simple array with Nearest Post Office objects.
   */
  public function all(): array;

}
