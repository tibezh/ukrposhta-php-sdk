<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

class TrackingStatus implements TrackingStatusInterface
{
    /**
     * TrackingStatus constructor.
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

    public function getBarcode(): string
    {
        return $this->barcode;
    }

    public function getStep(): int
    {
        return $this->step;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getIndex(): ?string
    {
        return $this->index;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getEventReason(): ?string
    {
        return $this->eventReason;
    }

    public function getEventReasonId(): ?int
    {
        return $this->eventReasonId;
    }

    public function getMailType(): int
    {
        return $this->mailType;
    }

    public function getIndexOrder(): int
    {
        return $this->indexOrder;
    }
}
