<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking\Entities;

/**
 * Tracking Route main class.
 */
class TrackingRoute implements TrackingRouteInterface
{

    /**
     * TrackingRoute constructor.
     *
     * @param string $from
     *   Tracking Route 'from' information.
     * @param string $to
     *   Tracking Route 'from' information.
     */
    public function __construct(
        protected readonly string $from,
        protected readonly string $to
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * {@inheritDoc}
     */
    public function getTo(): string
    {
        return $this->to;
    }

}
