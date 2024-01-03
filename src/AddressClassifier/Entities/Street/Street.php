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
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * {@inheritDoc}
   */
  public function getName(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"name{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getType(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"type{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getShortType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"shortType{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(?LanguagesEnumInterface $language = null): array
  {
    $data = ['id' => $this->getId()];

    if (!$language) {
      $data['name_ua'] = $this->getName();
      $data['name_en'] = $this->getName(LanguagesEnum::EN);
      $data['type_ua'] = $this->getType();
      $data['type_en'] = $this->getType(LanguagesEnum::EN);
      $data['short_type_ua'] = $this->getShortType();
      $data['short_type_en'] = $this->getShortType(LanguagesEnum::EN);
    }
    else {
      $data['name'] = $this->getName($language);
      $data['type'] = $this->getType($language);
      $data['short_type'] = $this->getShortType($language);
    }

    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public static function fromResponseEntry(array $entry): StreetInterface {
    return new Street(
      id: (int) $entry['STREET_ID'],
      nameUa: $entry['STREET_UA'],
      nameEn: $entry['STREET_EN'],
      typeUa: $entry['STREETTYPE_UA'],
      typeEn: $entry['STREETTYPE_EN'],
      shortTypeUa: $entry['SHORTSTREETTYPE_UA'],
      shortTypeEn: $entry['SHORTSTREETTYPE_EN'],
    );
  }

}
