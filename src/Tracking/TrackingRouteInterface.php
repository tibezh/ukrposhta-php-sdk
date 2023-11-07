<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

/**
 *
 */
interface TrackingRouteInterface {

  /**
   * @return string
   */
  public function getFrom(): string;

  /**
   * @return string
   */
  public function getTo(): string;

}
