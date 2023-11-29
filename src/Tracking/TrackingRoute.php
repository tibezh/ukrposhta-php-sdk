<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

class TrackingRoute implements TrackingRouteInterface
{
    /**
     * TrackingRoute constructor.
     */
    public function __construct(
        protected readonly string $from,
        protected readonly string $to
    ) {
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }
}
