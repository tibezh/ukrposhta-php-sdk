<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for District entity.
 */
interface DistrictInterface extends EntityInterface {

  /**
   * Gets district ID.
   *
   * @return int
   *   The district ID.
   */
  public function getId(): int;

  /**
   * Gets district name.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   The district name.
   */
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets district koatuu code.
   *
   * @return int
   *   The district koatuu code
   */
  public function getKoatuu(): int;

  /**
   * Gets district katottg code.
   *
   * @return int
   *   The district katottg code
   */
  public function getKatottg(): int;

  /**
   * Gets an associative array version of the District.
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
  public static function fromResponseEntry(array $entry): DistrictInterface;

}
