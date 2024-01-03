<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

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
  public function getKatottg(): int
  {
    return $this->katottg;
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
  public function toArray(?LanguagesEnumInterface $language = null): array
  {
    $data = [
      'id' => $this->getId(),
      'katottg' => $this->getKatottg(),
      'koatuu' => $this->getKoatuu(),
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
  public static function fromResponseEntry(array $entry): RegionInterface {
    return new Region(
      id: (int) $entry['REGION_ID'],
      nameUa: $entry['REGION_UA'],
      nameEn: $entry['REGION_EN'],
      koatuu: (int) $entry['REGION_KOATUU'],
      katottg: (int) $entry['REGION_KATOTTG']
    );
  }

}
