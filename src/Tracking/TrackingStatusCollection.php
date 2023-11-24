<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 *
 */
class TrackingStatusCollection implements TrackingStatusCollectionInterface {

  /**
   * @var array
   */
  private array $items = [];

  /**
   * @var int
   */
  private int $position = 0;

  /**
   * @param TrackingStatusInterface[] $items
   */
  public function __construct(array $items = []) {
    foreach ($items as $item) {
      $this->add($item);
    }
  }

  /**
   * @inheritDoc
   */
  public function add(TrackingStatusInterface $trackingStatus): void
  {
    $this->items[] = $trackingStatus;
  }

  /**
   * @inheritDoc
   */
  public function all(): array
  {
    return $this->items;
  }

  /**
   * @inheritDoc
   */
  public function key(): int
  {
    return $this->position;
  }

  /**
   * @inheritDoc
   */
  public function rewind(): void
  {
    $this->position = 0;
  }

  /**
   * @inheritDoc
   */
  public function current(): TrackingStatusInterface
  {
    return $this->items[$this->position];
  }

  /**
   * @inheritDoc
   */
  public function next(): void
  {
    $this->position++;
  }

  /**
   * @inheritDoc
   */
  public function valid(): bool
  {
    return isset($this->items[$this->position]);
  }

  /**
   * @inheritDoc
   */
  public function count(): int
  {
    return count($this->items);
  }

}
