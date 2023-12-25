<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for Street entity.
 */
interface StreetInterface {

  /**
   * Gets street ID.
   *
   * @return int
   *   ID of the street.
   */
  public function id(): int;

  /**
   * Gets street name.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string
   *   Name of the street.
   */
  public function name(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets street type.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string
   *   Type of the street.
   */
  public function type(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets street short type.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string|null
   *   Short type of the street, can be null for specific languages.
   */
  public function shortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string;

}
