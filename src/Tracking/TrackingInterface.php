<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

use Ukrposhta\Tracking\Entities\TrackingRouteInterface;
use Ukrposhta\Tracking\Entities\TrackingStatusCollectionInterface;
use Ukrposhta\Tracking\Entities\TrackingStatusInterface;

/**
 * Tracking interface to request tracking status by barcode.
 */
interface TrackingInterface
{

    /**
     * Requests last tracking status by barcode.
     *
     * URI: `/statuses/last?barcode={barcode}`
     *
     * @param string $barcode
     *   Barcode for the request.
     *
     * @return TrackingStatusInterface
     *   Tracking Status object with last status for the given barcode.
     */
    public function requestBarcodeLastStatus(string $barcode): TrackingStatusInterface;

    /**
     * Requests all statuses by barcode.
     *
     * URI: `/statuses?barcode={barcode}`
     *
     * @param string $barcode
     *   Barcode for the request.
     * @return TrackingStatusCollectionInterface
     *   Collection of Tracking Status objects for the given barcode.
     */
    public function requestBarcodeStatuses(string $barcode): TrackingStatusCollectionInterface;

    /**
     * Request route by barcode.
     *
     * URI: `/barcodes/{barcode}/route`
     *
     * @param string $barcode
     *   Barcode for the request.
     * @return TrackingRouteInterface
     *   Tracking Route object for the given barcode.
     */
    public function requestBarcodeRoute(string $barcode): TrackingRouteInterface;

}
