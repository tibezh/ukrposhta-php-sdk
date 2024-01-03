<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for Street entity.
 */
interface StreetInterface extends EntityInterface {

  /**
   * Gets street ID.
   *
   * @return int
   *   ID of the street.
   */
  public function getId(): int;

  /**
   * Gets street name.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string
   *   Name of the street.
   */
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets street type.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string
   *   Type of the street.
   */
  public function getType(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets street short type.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   * @return string|null
   *   Short type of the street, can be null for specific languages.
   */
  public function getShortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string;

  /**
   * Gets an associative array version of the Street.
   *
   * @param LanguagesEnumInterface|null $language
   *   Language of the value to return, NULL by default which returns all values.
   *
   * @return array<string, mixed>
   *    Array version of the object.
   */
  public function toArray(?LanguagesEnumInterface $language = null): array;

  /**
   * {@inheritDoc}
   */
  public static function fromResponseEntry(array $entry): StreetInterface;

}
