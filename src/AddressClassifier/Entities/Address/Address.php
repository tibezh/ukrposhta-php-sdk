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
  public function getPostCode(): int
  {
    return $this->postCode;
  }

  /**
   * {@inheritDoc}
   */
  public function getHouseNumber(): string
  {
    return $this->houseNumber;
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(): array
  {
    return [
      'post_code' => $this->getPostCode(),
      'house_number' => $this->getHouseNumber(),
    ];
  }

}
