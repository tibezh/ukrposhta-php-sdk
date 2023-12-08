<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking\Entities;

/**
 * Tracking Status interface.
 */
interface TrackingStatusInterface
{

    /**
     * Gets barcode.
     *
     * @return string
     */
    public function getBarcode(): string;

    /**
     * Get step number.
     *
     * @return int
     */
    public function getStep(): int;

    /**
     * Gets date value.
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime;

    /**
     * @return string|null
     */
    public function getIndex(): ?string;

    /**
     * Gets name value.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Gets event ID.
     *
     * @return int
     */
    public function getEventId(): int;

    /**
     * Gets event name.
     *
     * @return string
     */
    public function getEventName(): string;

    /**
     * Gets country.
     *
     * @return string
     */
    public function getCountry(): string;

    /**
     * Gets event reason.
     *
     * @return string|null
     */
    public function getEventReason(): ?string;

    /**
     * Gets event reason ID.
     *
     * @return int|null
     */
    public function getEventReasonId(): ?int;

    /**
     * @return int
     */
    public function getMailType(): int;

    /**
     * Gets index order number.
     *
     * @return int
     */
    public function getIndexOrder(): int;

    /**
     * Gets an associative array version of the object.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

}
