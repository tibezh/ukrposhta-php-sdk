<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 *
 */
interface TrackingStatusInterface {

  /**
   * @return string
   */
  public function getBarcode(): string;

  /**
   * @return int
   */
  public function getStep(): int;

  /**
   * @return \DateTime
   */
  public function getDate(): \DateTime;

  /**
   * @return string|null
   */
  public function getIndex(): ?string;

  /**
   * @return string
   */
  public function getName(): string;

  /**
   * @return int
   */
  public function getEventId(): int;

  /**
   * @return string
   */
  public function getEventName(): string;

  /**
   * @return string
   */
  public function getCountry(): string;

  /**
   * @return string|null
   */
  public function getEventReason(): ?string;

  /**
   * @return int|null
   */
  public function getEventReasonId(): ?int;

  /**
   * @return int
   */
  public function getMailType(): int;

  /**
   * @return int
   */
  public function getIndexOrder(): int;

}
