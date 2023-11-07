<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 *
 */
class TrackingStatus implements TrackingStatusInterface {

  /**
   * TrackingStatus constructor.
   *
   * @param string $barcode
   * @param int $step
   * @param \DateTime $date
   * @param string|null $index
   * @param int $eventId
   * @param string $eventName
   * @param string $country
   * @param string|null $eventReason
   * @param int|null $eventReasonId
   * @param int $mailType
   * @param int $indexOrder
   */
  public function __construct(
    protected readonly string $barcode,
    protected readonly int $step,
    protected readonly \DateTime $date,
    protected readonly ?string $index,
    protected readonly int $eventId,
    protected readonly string $eventName,
    protected readonly string $country,
    protected readonly ?string $eventReason,
    protected readonly ?int $eventReasonId,
    protected readonly int $mailType,
    protected readonly int $indexOrder
  ) {
  }

  /**
   * {@inheritDoc}
   */
  public function getBarcode(): string
  {
    return $this->barcode;
  }

  /**
   * {@inheritDoc}
   */
  public function getStep(): int
  {
    return $this->step;
  }

  /**
   * {@inheritDoc}
   */
  public function getDate(): \DateTime
  {
    return $this->date;
  }

  /**
   * {@inheritDoc}
   */
  public function getIndex(): string
  {
    return $this->index;
  }

  /**
   * {@inheritDoc}
   */
  public function getName(): string
  {
    return $this->index;
  }

  /**
   * {@inheritDoc}
   */
  public function getEventId(): int
  {
    return $this->eventId;
  }

  /**
   * {@inheritDoc}
   */
  public function getEventName(): string
  {
    return $this->eventName;
  }

  /**
   * {@inheritDoc}
   */
  public function getCountry(): string
  {
    return $this->country;
  }

  /**
   * {@inheritDoc}
   */
  public function getEventReason(): ?string
  {
    return $this->eventReason;
  }

  /**
   * {@inheritDoc}
   */
  public function getEventReasonId(): ?int
  {
    return $this->eventReasonId;
  }

  /**
   * {@inheritDoc}
   */
  public function getMailType(): int
  {
    return $this->mailType;
  }

  /**
   * {@inheritDoc}
   */
  public function getIndexOrder(): int
  {
    return $this->indexOrder;
  }


}
