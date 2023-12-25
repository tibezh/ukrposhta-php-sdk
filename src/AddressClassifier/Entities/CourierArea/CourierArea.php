<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\CourierArea;

/**
 *
 */
class CourierArea implements CourierAreaInterface {

  /**
   * CourierArea constructor.
   *
   * @param bool $isCourierArea
   *   Is Courier Area value.
   */
  public function __construct(
    protected readonly bool $isCourierArea
  ) {

  }

  /**
   * {@inheritDoc}
   */
  public function isCourierArea(): bool
  {
    return $this->isCourierArea;
  }

}