<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;

/**
 * Region main class.
 */
class Region implements RegionInterface {

  /**
   * Region constructor.
   *
   * @param int $id
   *   Region ID.
   * @param string $nameUa
   *   Region name on UA language.
   * @param string $nameEn
   *   Region name on EN language.
   * @param int $koatuu
   *   Region KOATUU code.
   * @param int $katottg
   *   Region KATOTTG code.
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
  public function name(LanguagesEnum $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"name{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function katottg(): int
  {
    return $this->katottg;
  }

  /**
   * {@inheritDoc}
   */
  public function koatuu(): int
  {
    return $this->koatuu;
  }

}
