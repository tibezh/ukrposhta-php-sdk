<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 * Provides required methods for PostOffice entity.
 */
interface PostOfficeInterface {

  /**
   * Gets unique identifier.
   *
   * @return int
   *   ID of the Post Office.
   */
  public function id(): int;

  /**
   * Gets code.
   *
   * @return int
   *   Code of the Post Office.
   */
  public function code(): int;

  /**
   * Gets long name.
   *
   * Warning! UA language only.
   *
   * @return string
   *   Long name of the Post Office on UA language.
   */
  public function name(): string;

  /**
   * Gets type.
   *
   * Warning! UA language only.
   *
   * @return string
   *   Type of the Post Office.
   */
  public function type(): string;

  /**
   * Gets short type.
   *
   * Warning! UA language only.
   *
   * @return string
   *   Short type of the Post Office.
   */
  public function typeShort(): string;

  /**
   * Gets type acronym.
   *
   * @return string
   *   Type acronym of the Post Office.
   */
  public function typeAcronym(): string;

  /**
   * Gets post code.
   *
   * @return int
   *   Post code of the Post Office.
   */
  public function postCode(): int;

  /**
   * Gets mereza number.
   *
   * @return int
   *   Mereza number of the Post Office.
   */
  public function merezaNumber(): int;

  /**
   * Gets lock description.
   *
   * @param LanguagesEnumInterface $language
   *   Name in language, LanguagesEnum::UA by default.
   *
   * @return string
   *   Lock description of the Post Office.
   */
  public function lock(LanguagesEnumInterface $language = LanguagesEnum::UA): string;

  /**
   * Gets lock code.
   *
   * @return int
   *   Lock code of the Post Office.
   */
  public function lockCode(): int;

  /**
   * Gets region ID.
   *
   * @return int
   *   Region ID of the Post Office.
   */
  public function regionId(): int;

  /**
   * Gets district ID.
   *
   * @return int
   *   District ID of the Post Office.
   */
  public function districtId(): int;

  /**
   * Gets city ID.
   *
   * @return int
   *   City ID of the Post Office.
   */
  public function cityId(): int;

  /**
   * Gets city type.
   *
   * Warning! UA language only.
   *
   * @return string
   *   City type of the Post Office.
   */
  public function cityType(): string;

  /**
   * Gets street ID.
   *
   * @return int
   *   Street ID of the Post Office.
   */
  public function streetId(): int;

  /**
   * Gets parent ID.
   *
   * Identifier of the parent Post Office that was find by post index.
   *
   * @return int
   *   Parent ID of the Post Office.
   */
  public function parentId(): int;

  /**
   * Gets address
   *
   * @return string
   *   Address of the Post Office.
   */
  public function address(): string;

  /**
   * Get phone number.
   *
   * @return string
   *   Phone number of the Post Office.
   */
  public function phone(): string;

  /**
   * Gets longitude.
   *
   * @return float
   *   Longitude of the Post Office.
   */
  public function longitude(): float;

  /**
   * Gets latitude.
   *
   * @return float
   *   Latitude of the Post Office.
   */
  public function latitude(): float;

  /**
   * Gets vpz sign.
   *
   * Post Office can also be sorting.
   *
   * @return bool
   *   True value if the Post Office has vpz sign, otherwise false.
   */
  public function isVpz(): bool;

  /**
   * Gets available status.
   *
   * @return bool
   *   True value if the Post Office is available, otherwise false.
   */
  public function isAvailable(): bool;

  /**
   * Gets mrtps code.
   *
   * The code indicating the location of the mobile post office in the settlement:
   * 1 – absent;
   * 2 – in the premises of the village council;
   * 3 – in the premises of the former VZP;
   * 4 – in the cultural center;
   * 5 – in the library;
   * 6 – in the store;
   * 7 – at a gas station;
   * 8 – in the sorting center;
   * 9 - other.
   *
   * @todo probably can be defined via enum.
   *
   * @return int
   *   Mrtps code of the Post Office.
   */
  public function mrtps(): int;

  /**
   * Gets internal technical index.
   *
   * @return int
   *   Internal technical index of the Post Office.
   */
  public function techIndex(): int;

}
