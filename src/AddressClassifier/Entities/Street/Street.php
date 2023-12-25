<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class Street implements StreetInterface {

  /**
   * Street constructor.
   *
   * @param int $id
   *   Street ID.
   * @param string $nameUa
   *   Name on UA language.
   * @param string $nameEn
   *   Name on EN language.
   * @param string $shortTypeUa
   *   Short type on UA language.
   * @param string|null $shortTypeEn
   *   Short type on EN language.
   */
  public function __construct(
    protected readonly int $id,
    protected readonly string $nameUa,
    protected readonly string $nameEn,
    protected readonly string $typeUa,
    protected readonly string $typeEn,
    protected readonly string $shortTypeUa,
    protected readonly ?string $shortTypeEn
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
  public function type(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"type{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function shortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"shortType{$propSuffix}"};
  }

}
