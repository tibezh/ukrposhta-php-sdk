<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

/**
 * Address postal code entity.
 */
class Address implements AddressInterface {

  /**
   * Address constructor.
   *
   * @param int $postCode
   *   Post code value.
   */
  public function __construct(
    protected readonly int $postCode,
    protected readonly string $houseNumber
  ) {
  }

  /**
   * {@inheritDoc}
   */
  public function postCode(): int
  {
    return $this->postCode;
  }

  /**
   * {@inheritDoc}
   */
  public function houseNumber(): string
  {
    return $this->houseNumber;
  }

}
