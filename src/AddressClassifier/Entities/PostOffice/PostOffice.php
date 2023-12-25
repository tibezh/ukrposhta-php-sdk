<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class PostOffice implements PostOfficeInterface {

  /**
   * PostOffice constructor.
   *
   * @param int $id
   *   ID value.
   * @param int $code
   *   Code value.
   * @param string $name
   *   Long Name in UA language.
   * @param string $type
   *   Short name in UA language.
   * @param string $typeShort
   *   Sort type in UA language.
   * @param string $typeAcronym
   *   Type acronym.
   * @param int $postIndex
   *   Post index.
   * @param int $postCode
   *   Post code.
   * @param int $merezaNumber
   * @param string $lockUa
   *   Lock in UA language.
   * @param string $lockEn
   *   Lock in EN language.
   * @param int $lockCode
   *   Lock code.
   * @param int $regionId
   *   Region ID.
   * @param int $districtId
   *   District ID.
   * @param int $cityId
   *   City ID.
   *   City name in EN language.
   * @param string $cityType
   *   City type in UA language.
   * @param int $streetId
   *   Street ID.
   * @param int $parentId
   *   Parent ID.
   * @param string $address
   *   Address value.
   * @param string $phone
   *   Phone number.
   * @param float $longitude
   *   Post Office longitude.
   * @param float $latitude
   *   Post Office latitude.
   * @param bool $isVpz
   *   Is vpz status.
   * @param bool $isAvailable
   *   Is available status.
   * @param int $mrtps
   *   Mrtps code.
   * @param int $techIndex
   *   Technical index.
   */
  public function __construct(
    protected readonly int $id,
    protected readonly int $code,
    protected readonly string $name,
    protected readonly string $type,
    protected readonly string $typeShort,
    protected readonly string $typeAcronym,
    protected readonly int $postIndex,
    protected readonly int $postCode,
    protected readonly int $merezaNumber,
    protected readonly string $lockUa,
    protected readonly string $lockEn,
    protected readonly int $lockCode,
    protected readonly int $regionId,
    protected readonly int $districtId,
    protected readonly int $cityId,
    protected readonly string $cityType,
    protected readonly int $streetId,
    protected readonly int $parentId,
    protected readonly string $address,
    protected readonly string $phone,
    protected readonly float $longitude,
    protected readonly float $latitude,
    protected readonly bool $isVpz,
    protected readonly bool $isAvailable,
    protected readonly int $mrtps,
    protected readonly int $techIndex
  ) {
  }

  /**
   * {@inheritDoc}
   */
  public function id(): int
  {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function code(): int
  {
    return $this->code;
  }

  /**
   * {@inheritDoc}
   */
  public function name(): string
  {
    return $this->name;
  }

  /**
   * {@inheritDoc}
   */
  public function type(): string
  {
    return $this->type;
  }

  /**
   * {@inheritDoc}
   */
  public function typeShort(): string
  {
    return $this->typeShort;
  }

  /**
   * {@inheritDoc}
   */
  public function typeAcronym(): string
  {
    return $this->typeAcronym;
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
  public function merezaNumber(): int
  {
    return $this->merezaNumber;
  }

  /**
   * {@inheritDoc}
   */
  public function lock(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"lock{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function lockCode(): int
  {
    return $this->lockCode;
  }

  /**
   * {@inheritDoc}
   */
  public function regionId(): int
  {
    return $this->regionId;
  }

  /**
   * {@inheritDoc}
   */
  public function districtId(): int
  {
    return $this->districtId;
  }

  /**
   * {@inheritDoc}
   */
  public function cityId(): int
  {
    return $this->cityId;
  }

  /**
   * {@inheritDoc}
   */
  public function cityType(): string
  {
    return $this->cityType;
  }

  /**
   * {@inheritDoc}
   */
  public function streetId(): int
  {
    return $this->streetId;
  }

  /**
   * {@inheritDoc}
   */
  public function parentId(): int
  {
    return $this->parentId;
  }

  /**
   * {@inheritDoc}
   */
  public function address(): string
  {
    return $this->address;
  }

  /**
   * {@inheritDoc}
   */
  public function phone(): string
  {
    return $this->phone;
  }

  /**
   * {@inheritDoc}
   */
  public function longitude(): float
  {
    return $this->longitude;
  }

  /**
   * {@inheritDoc}
   */
  public function latitude(): float
  {
    return $this->latitude;
  }

  /**
   * {@inheritDoc}
   */
  public function isVpz(): bool
  {
    return $this->isVpz;
  }

  /**
   * {@inheritDoc}
   */
  public function isAvailable(): bool
  {
    return $this->isAvailable;
  }

  /**
   * {@inheritDoc}
   */
  public function mrtps(): int
  {
    return $this->mrtps;
  }

  /**
   * {@inheritDoc}
   */
  public function techIndex(): int
  {
    return $this->techIndex;
  }

}
