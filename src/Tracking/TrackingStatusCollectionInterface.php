<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;


interface TrackingStatusCollectionInterface {

  /**
   * @param TrackingStatusInterface $trackingStatus
   * @return void
   */
  public function add(TrackingStatusInterface $trackingStatus): void;

  /**
   * @return array
   */
  public function all(): array;

  /**
   * @return int
   */
  public function key(): int;

  /**
   * @return void
   */
  public function rewind(): void;

  /**
   * @return TrackingStatusInterface
   */
  public function current(): TrackingStatusInterface;

  /**
   * @return void
   */
  public function next(): void;

  /**
   * @return bool
   */
  public function valid(): bool;

  /**
   * @return int
   */
  public function count(): int;

}
