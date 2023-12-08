<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking\Entities;

/**
 * Tracking Route interface.
 */
interface TrackingRouteInterface
{

    /**
     * Gets 'from' route information.
     *
     * @return string
     */
    public function getFrom(): string;

    /**
     * Gets 'to' route information.
     *
     * @return string
     */
    public function getTo(): string;

}
