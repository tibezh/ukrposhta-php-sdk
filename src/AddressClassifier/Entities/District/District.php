<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class District implements DistrictInterface {

  /**
   * District constructor.
   *
   * @param int $id
   *   District ID.
   * @param string $nameUa
   *   Region name on UA language.
   * @param string $nameEn
   *   Region name on EN language.
   * @param int $koatuu
   *   District KOATUU code.
   * @param int $katottg
   *   District KATOTTG code.
   */
  public function __construct(
    protected readonly int $id,
    protected readonly string $nameUa,
    protected readonly string $nameEn,
    protected readonly int $koatuu,
    protected readonly int $katottg
  ) {
  }

  /**
   * {@inheritDoc}
   */
  public function id(): int
  {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function name(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"name{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function koatuu(): int
  {
    return $this->koatuu;
  }

  /**
   * {@inheritDoc}
   */
  public function katottg(): int
  {
    return $this->katottg;
  }

}
