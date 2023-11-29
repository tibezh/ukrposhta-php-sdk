<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

interface TrackingRouteInterface
{
    public function getFrom(): string;

    public function getTo(): string;
}
