<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

/**
 *
 */
interface PostOfficeCollectionInterface
{

  /**
   * Adds Post Office object to the collection.
   *
   * @param PostOfficeInterface $postOffice
   *   Post Office object to add.
   *
   * @return void
   */
  public function add(PostOfficeInterface $postOffice): void;

  /**
   * Gets all Post Office collection in array.
   *
   * @return array<int, PostOfficeInterface>
   *   Simple array with Post Office objects.
   */
  public function all(): array;

}
