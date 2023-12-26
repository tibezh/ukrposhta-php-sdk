<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\NearestPostOffice;

/**
 *
 */
class NearestPostOffice implements NearestPostOfficeInterface
{

  /**
   * NearestPostOffice constructor.
   *
   * @param int $id
   * @param string $cityName
   * @param string $address
   * @param string $filialName
   * @param int $distance
   */
  public function __construct(
    protected readonly int $id,
    protected readonly string $cityName,
    protected readonly string $address,
    protected readonly string $filialName,
    protected readonly int $distance,
  ) {

  }

  /**
   * {@inheritDoc}
   */
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function getCityName(): string
  {
    return $this->cityName;
  }

  /**
   * {@inheritDoc}
   */
  public function getAddress(): string
  {
    return $this->address;
  }

  /**
   * {@inheritDoc}
   */
  public function getFilialName(): string
  {
    return $this->filialName;
  }

  /**
   * {@inheritDoc}
   */
  public function getDistance(): int
  {
    return $this->distance;
  }

}
