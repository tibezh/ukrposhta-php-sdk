<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Settlement;

/**
 *
 */
class SettlementCollection implements SettlementCollectionInterface
{

  /**
   * Simple array of Settlement objects.
   *
   * @var array<int, SettlementInterface>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(SettlementInterface $settlement): void
  {
    $this->items[] = $settlement;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
