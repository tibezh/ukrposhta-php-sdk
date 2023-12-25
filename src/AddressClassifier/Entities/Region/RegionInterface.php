<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;

/**
 * Provides required methods for Region entity.
 */
interface RegionInterface {

  /**
   * Gets region ID.
   *
   * @return int
   *   The ID of the region.
   */
  public function id(): int;

  /**
   * Gets region name.
   *
   * @param LanguagesEnum $language
   *   Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Region name in specific language.
   */
  public function name(LanguagesEnum $language = LanguagesEnum::UA): string;

  /**
   * Gets region katottg code.
   *
   * @return int
   *   The katottg code of the region.
   */
  public function katottg(): int;

  /**
   * Gets region koatuu code.
   *
   * @return int
   *   The koatuu code of the region.
   */
  public function koatuu(): int;

}
