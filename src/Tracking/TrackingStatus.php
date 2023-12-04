<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 * Tracking Status class.
 */
class TrackingStatus implements TrackingStatusInterface
{
    /**
     * TrackingStatus constructor.
     *
     * @param string $barcode
     *   Barcode value.
     * @param int $step
     *   Step number.
     * @param \DateTime $date
     *   Date value.
     * @param string $name
     *   Name value.
     * @param int $eventId
     *   Event ID value.
     * @param string $eventName
     *   Event name value.
     * @param string $country
     *   Country value.
     * @param int $mailType
     *   Mail value.
     * @param int $indexOrder
     *   Index order number.
     * @param string|null $index
     *   Index information value if exists.
     * @param string|null $eventReason
     *   Event reason value if exists.
     * @param int|null $eventReasonId
     *   Event reason ID if exists.
     */
    public function __construct(
        protected readonly string $barcode,
        protected readonly int $step,
        protected readonly \DateTime $date,
        protected readonly string $name,
        protected readonly int $eventId,
        protected readonly string $eventName,
        protected readonly string $country,
        protected readonly int $mailType,
        protected readonly int $indexOrder,
        protected readonly ?string $index = null,
        protected readonly ?string $eventReason = null,
        protected readonly ?int $eventReasonId = null
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
    public function getIndex(): ?string
    {
        return $this->index;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
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

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
          'barcode' => $this->getBarcode(),
          'step' => $this->getStep(),
          'date' => $this->getDate(),
          'name' => $this->getName(),
          'event_id' => $this->getEventId(),
          'event_name' => $this->getEventName(),
          'country' => $this->getCountry(),
          'mail_type' => $this->getMailType(),
          'index_order' => $this->getIndexOrder(),
          'index' => $this->getIndex(),
          'event_reason' => $this->getEventReason(),
          'event_reason_id' => $this->getEventReasonId(),
        ];
    }

}
