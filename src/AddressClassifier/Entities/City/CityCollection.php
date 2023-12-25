<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

/**
 *
 */
class CityCollection implements CityCollectionInterface
{

  /**
   * Simple array of City objects.
   *
   * @var array<int, CityInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(CityInterface $city): void
  {
    $this->items[] = $city;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
