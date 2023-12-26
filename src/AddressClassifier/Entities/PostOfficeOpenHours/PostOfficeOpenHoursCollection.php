<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours;

/**
 *
 */
class PostOfficeOpenHoursCollection implements PostOfficeOpenHoursCollectionInterface
{

  /**
   * Simple array of Post Office Open Hours objects.
   *
   * @var array<int, PostOfficeOpenHours>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(PostOfficeOpenHours $postOfficeOpenHours): void
  {
    $this->items[] = $postOfficeOpenHours;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
