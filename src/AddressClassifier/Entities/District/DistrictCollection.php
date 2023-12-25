<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

/**
 *
 */
class DistrictCollection implements DistrictCollectionInterface
{

  /**
   * Simple array of District objects.
   *
   * @var array<int, DistrictInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(DistrictInterface $district): void
  {
    $this->items[] = $district;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
