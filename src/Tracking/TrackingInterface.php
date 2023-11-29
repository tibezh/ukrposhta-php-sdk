<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

interface TrackingInterface
{
    public function requestBarcodeLastStatus(string $barcode): TrackingStatusInterface;

    public function requestBarcodeStatuses(string $barcode): TrackingStatusCollectionInterface;

    public function requestBarcodeRoute(string $barcode): TrackingRouteInterface;
}
