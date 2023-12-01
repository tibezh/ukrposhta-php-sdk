<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

interface TrackingStatusInterface
{
    public function getBarcode(): string;

    public function getStep(): int;

    public function getDate(): \DateTime;

    public function getIndex(): ?string;

    public function getName(): string;

    public function getEventId(): int;

    public function getEventName(): string;

    public function getCountry(): string;

    public function getEventReason(): ?string;

    public function getEventReasonId(): ?int;

    public function getMailType(): int;

    public function getIndexOrder(): int;

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
