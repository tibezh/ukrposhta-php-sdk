<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 *
 */
interface TrackingInterface {

  /**
   * @param string $barcode
   * @return TrackingStatusInterface
   */
  public function requestBarcodeLastStatus(string $barcode): TrackingStatusInterface;

  /**
   * @param string $barcode
   * @return TrackingStatusCollectionInterface
   */
  public function requestBarcodeStatuses(string $barcode): TrackingStatusCollectionInterface;

  /**
   * @param string $barcode
   * @return TrackingRouteInterface
   */
  public function requestBarcodeRoute(string $barcode): TrackingRouteInterface;

}
