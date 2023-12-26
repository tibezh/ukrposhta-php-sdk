<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement;

/**
 *
 */
class PostOfficeSettlementCollection implements PostOfficeSettlementCollectionInterface
{

  /**
   * Simple array of Post Office Settlement objects.
   *
   * @var array<int, PostOfficeSettlement>
   */
  private array $items = [];

  /**
   * {@inheritDoc}
   */
  public function add(PostOfficeSettlement $postOfficeSettlement): void
  {
    $this->items[] = $postOfficeSettlement;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
