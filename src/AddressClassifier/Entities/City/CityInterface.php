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
  public function id(): int;

  /**
   * City name.
   *
   * @param LanguagesEnumInterface $language
   *  Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Name of the city.
   */
  public function name(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * City type.
   *
   * @param LanguagesEnumInterface $language
   *   Type in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Type of the city.
   */
  public function type(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * City short type.
   *
   * @param LanguagesEnumInterface $language
   *   Short type in language, LanguagesEnum::UA by default.
   *
   * @return string|null
   *   Short type of the city, can be null for non default languages.
   */
  public function shortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string;

  /**
   * Gets city katottg code.
   *
   * @return int
   *   The city katottg code
   */
  public function katottg(): int;

  /**
   * Gets city koatuu code.
   *
   * @return int
   *   The city koatuu code
   */
  public function koatuu(): int;

  /**
   * Gets city longitude.
   *
   * @return float
   *   Longitude of the city.
   */
  public function longitude(): float;

  /**
   * Gets city latitude.
   *
   * @return float
   *   Latitude of the city.
   */
  public function latitude(): float;

  /**
   * Gets city population.
   *
   * @return int
   *   Population of the city.
   */
  public function population(): int;

}
