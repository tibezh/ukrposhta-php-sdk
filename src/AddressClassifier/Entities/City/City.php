<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class City implements CityInterface {

  /**
   * City constructor.
   *
   * @param int $id
   *   City ID.
   * @param string $nameUa
   *   Name on UA language.
   * @param string $nameEn
   *   Name on EN language.
   * @param string $typeUa
   *   Type on UA language.
   * @param string $typeEn
   *   Type on EN language.
   * @param string $shortTypeUa
   *   Short type on UA language.
   * @param string|null $shortTypeEn
   *   Short type on EN language.
   * @param int $katottg
   *   Katottg code.
   * @param int $koatuu
   *   Koatuu code.
   * @param float $longitude
   *   City longitude.
   * @param float $latitude
   *   City latitude.
   * @param int $population
   *   City population.
   */
  public function __construct(
    protected readonly int $id,
    protected readonly string $nameUa,
    protected readonly string $nameEn,
    protected readonly string $typeUa,
    protected readonly string $typeEn,
    protected readonly string $shortTypeUa,
    protected readonly ?string $shortTypeEn,
    protected readonly int $katottg,
    protected readonly int $koatuu,
    protected readonly float $longitude,
    protected readonly float $latitude,
    protected readonly int $population,
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
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"name{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getType(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"type{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getShortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"shortType{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getKatottg(): int
  {
    return $this->katottg;
  }

  /**
   * {@inheritDoc}
   */
  public function getKoatuu(): int
  {
    return $this->koatuu;
  }

  /**
   * {@inheritDoc}
   */
  public function getLongitude(): float
  {
    return $this->longitude;
  }

  /**
   * {@inheritDoc}
   */
  public function getLatitude(): float
  {
    return $this->latitude;
  }

  /**
   * {@inheritDoc}
   */
  public function getPopulation(): int
  {
    return $this->population;
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(?LanguagesEnumInterface $language = null): array
  {

    $data = [
      'id' => $this->getId(),
      'katottg' => $this->getKatottg(),
      'koatuu' => $this->getKoatuu(),
      'longitude' => $this->getLongitude(),
      'latitude' => $this->getLatitude(),
      'population' => $this->getPopulation(),
    ];

    if (!$language) {
      $data['name_ua'] = $this->getName();
      $data['name_en'] = $this->getName(LanguagesEnum::EN);
      $data['type_ua'] = $this->getType();
      $data['type_en'] = $this->getType(LanguagesEnum::EN);
      $data['short_type_ua'] = $this->getShortType();
      $data['short_type_en'] = $this->getShortType(LanguagesEnum::EN);
    }
    else {
      $data['name'] = $this->getName($language);
      $data['type'] = $this->getType($language);
      $data['short_type'] = $this->getShortType($language);
    }

    return $data;
  }

}
