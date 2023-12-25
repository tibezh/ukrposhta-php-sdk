<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;
use Ukrposhta\AddressClassifier\Entities\Region\RegionInterface;

/**
 * Provides required methods for District entity.
 */
interface DistrictInterface {

  /**
   * Gets district ID.
   *
   * @return int
   *   The district ID.
   */
  public function id(): int;

  /**
   * Gets district name.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   The district name.
   */
  public function name(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets district koatuu code.
   *
   * @return int
   *   The district koatuu code
   */
  public function koatuu(): int;

  /**
   * Gets district katottg code.
   *
   * @return int
   *   The district katottg code
   */
  public function katottg(): int;

}
