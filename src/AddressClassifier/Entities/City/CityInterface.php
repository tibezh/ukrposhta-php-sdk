<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for City entity.
 */
interface CityInterface {

  /**
   * Gets city ID.
   *
   * @return int
   *   ID of the city.
   */
  public function getId(): int;

  /**
   * City name.
   *
   * @param LanguagesEnumInterface $language
   *  Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Name of the city.
   */
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * City type.
   *
   * @param LanguagesEnumInterface $language
   *   Type in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Type of the city.
   */
  public function getType(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * City short type.
   *
   * @param LanguagesEnumInterface $language
   *   Short type in language, LanguagesEnum::UA by default.
   *
   * @return string|null
   *   Short type of the city, can be null for non default languages.
   */
  public function getShortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string;

  /**
   * Gets city katottg code.
   *
   * @return int
   *   The city katottg code
   */
  public function getKatottg(): int;

  /**
   * Gets city koatuu code.
   *
   * @return int
   *   The city koatuu code
   */
  public function getKoatuu(): int;

  /**
   * Gets city longitude.
   *
   * @return float
   *   Longitude of the city.
   */
  public function getLongitude(): float;

  /**
   * Gets city latitude.
   *
   * @return float
   *   Latitude of the city.
   */
  public function getLatitude(): float;

  /**
   * Gets city population.
   *
   * @return int
   *   Population of the city.
   */
  public function getPopulation(): int;

  /**
   * Gets an associative array version of the City.
   *
   * @param LanguagesEnumInterface|null $language
   *   Language of the value to return, NULL by default which returns all values.
   *
   * @return array<string, mixed>
   *    Array version of the object.
   */
  public function toArray(?LanguagesEnumInterface $language = null): array;

}
