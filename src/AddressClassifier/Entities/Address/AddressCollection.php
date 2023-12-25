<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

/**
 *
 */
class AddressCollection implements AddressCollectionInterface
{

  /**
   * Simple array of Address objects.
   *
   * @var array<int, AddressInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(AddressInterface $address): void
  {
    $this->items[] = $address;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
