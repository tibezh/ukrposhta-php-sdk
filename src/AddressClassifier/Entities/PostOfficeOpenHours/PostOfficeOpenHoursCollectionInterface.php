<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours;

/**
 *
 */
interface PostOfficeOpenHoursCollectionInterface
{

  /**
   * Adds Post Office Settlement object to the collection.
   *
   * @param PostOfficeOpenHours $postOfficeOpenHours
   *   Post Office Open Hours object to add.
   *
   * @return void
   */
  public function add(PostOfficeOpenHours $postOfficeOpenHours): void;

  /**
   * Gets all Post Office Open Hours collection in array.
   *
   * @return array<int, PostOfficeOpenHours>
   *   Simple array with Post Office Open Hours objects.
   */
  public function all(): array;

}
