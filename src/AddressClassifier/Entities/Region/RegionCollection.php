<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

/**
 *
 */
class RegionCollection implements RegionCollectionInterface
{

  /**
   * Simple array of Region objects.
   *
   * @var array<int, RegionInterface>
   */
  private array $items = [];

  /**
   * RegionCollection constructor.
   *
   * @param RegionInterface[] $items
   *   Simple array of Region object.
   */
  public function __construct(array $items = [])
  {
    foreach ($items as $item) {
      $this->add($item);
    }
  }

  /**
   * {@inheritDoc}
   */
  public function add(RegionInterface $region): void
  {
    $this->items[] = $region;
  }

  /**
   * {@inheritDoc}
   */
  public function all(): array
  {
    return $this->items;
  }

}
