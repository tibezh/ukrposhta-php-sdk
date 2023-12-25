<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

/**
 *
 */
class StreetCollection implements StreetCollectionInterface
{

  /**
   * Simple array of Street objects.
   *
   * @var array<int, StreetInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(StreetInterface $street): void
  {
    $this->items[] = $street;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
