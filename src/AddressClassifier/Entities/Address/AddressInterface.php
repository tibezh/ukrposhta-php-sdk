<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

/**
 * Provides required methods for Address entity.
 */
interface AddressInterface {

  /**
   * Gets address post code.
   *
   * @return int
   *   Post code of the address.
   */
  public function postCode(): int;

  /**
   * Gets address house number.
   *
   * @return string
   *   House number of the address.
   */
  public function houseNumber(): string;

}
