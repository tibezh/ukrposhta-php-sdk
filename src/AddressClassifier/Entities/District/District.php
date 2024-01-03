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
  public function getKoatuu(): int
  {
    return $this->koatuu;
  }

  /**
   * {@inheritDoc}
   */
  public function getKatottg(): int
  {
    return $this->katottg;
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(?LanguagesEnumInterface $language = null): array
  {
    $data = [
      'id' => $this->getId(),
      'koatuu' => $this->getKoatuu(),
      'katottg' => $this->getKatottg(),
    ];
    if (!$language) {
      $data['name_ua'] = $this->getName();
      $data['name_en'] = $this->getName(LanguagesEnum::EN);
    }
    else {
      $data['name'] = $this->getName($language);
    }
    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public static function fromResponseEntry(array $entry): DistrictInterface
  {
    return new District(
      id: (int) $entry['DISTRICT_ID'],
      nameUa: $entry['DISTRICT_UA'],
      nameEn: $entry['DISTRICT_EN'],
      koatuu: (int) $entry['DISTRICT_KOATUU'],
      katottg: (int) $entry['DISTRICT_KATOTTG']
    );
  }

}
