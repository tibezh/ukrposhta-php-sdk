<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for Region entity.
 */
interface RegionInterface extends EntityInterface {

  /**
   * Gets region ID.
   *
   * @return int
   *   The ID of the region.
   */
  public function getId(): int;

  /**
   * Gets region name.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Region name in specific language.
   */
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets region katottg code.
   *
   * @return int
   *   The katottg code of the region.
   */
  public function getKatottg(): int;

  /**
   * Gets region koatuu code.
   *
   * @return int
   *   The koatuu code of the region.
   */
  public function getKoatuu(): int;

  /**
   * Gets an associative array version of the Region.
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
  public static function fromResponseEntry(array $entry): RegionInterface;

}
