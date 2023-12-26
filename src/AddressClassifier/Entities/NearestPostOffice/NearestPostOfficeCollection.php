<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\NearestPostOffice;

/**
 *
 */
class NearestPostOfficeCollection implements NearestPostOfficeCollectionInterface
{

  /**
   * Simple array of Nearest Post Office objects.
   *
   * @var array<int, NearestPostOfficeInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(NearestPostOffice $nearestPostOffice): void
  {
    $this->items[] = $nearestPostOffice;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
