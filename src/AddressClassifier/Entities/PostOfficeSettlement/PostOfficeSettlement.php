<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class PostOfficeSettlement implements PostOfficeSettlementInterface
{

  /**
   * PostOfficeSettlement constructor.
   *
   * @param int $id
   * @param string $name
   * @param string $shortName
   * @param string $type
   * @param string $shortType
   * @param string $typeAcronym
   * @param int $parentId
   * @param int $cityId
   * @param string $cityUa
   * @param string $cityEn
   * @param string $cityTypeUa
   * @param string $cityTypeEn
   * @param string $shortCityTypeUa
   * @param string|null $shortCityTypeEn
   * @param int $postIndex
   * @param int $regionId
   * @param string $regionUa
   * @param string $regionEn
   * @param int $districtId
   * @param string $districtUa
   * @param string $districtEn
   * @param string $streetUa
   * @param string $streetEn
   * @param string $streetTypeUa
   * @param string $streetTypeEn
   * @param string $houseNumber
   * @param string $address
   * @param float $longitude
   * @param float $latitude
   * @param bool $isCash
   * @param bool $isDhl
   * @param bool $isSmartbox
   * @param bool $isUrgentPostalTransfers
   * @param bool $isFlagman
   * @param bool $hasPostTerminal
   * @param bool $isAutomated
   * @param bool $isSecurity
   * @param int $lockCode
   * @param string $lockUa
   * @param string $lockEn
   * @param string $phone
   * @param bool $isVpz
   * @param int $merezaNumber
   * @param int $techIndex
   */
  public function __construct(
    protected readonly int $id,
    protected readonly string $name,
    protected readonly string $shortName,
    protected readonly string $type,
    protected readonly string $shortType,
    protected readonly string $typeAcronym,
    protected readonly int $parentId,
    protected readonly int $cityId,
    protected readonly string $cityUa,
    protected readonly string $cityEn,
    protected readonly string $cityTypeUa,
    protected readonly string $cityTypeEn,
    protected readonly string $shortCityTypeUa,
    protected readonly ?string $shortCityTypeEn,
    protected readonly int $postIndex,
    protected readonly int $regionId,
    protected readonly string $regionUa,
    protected readonly string $regionEn,
    protected readonly int $districtId,
    protected readonly string $districtUa,
    protected readonly string $districtEn,
    protected readonly string $streetUa,
    protected readonly string $streetEn,
    protected readonly string $streetTypeUa,
    protected readonly string $streetTypeEn,
    protected readonly string $houseNumber,
    protected readonly string $address,
    protected readonly float $longitude,
    protected readonly float $latitude,
    protected readonly bool $isCash,
    protected readonly bool $isDhl,
    protected readonly bool $isSmartbox,
    protected readonly bool $isUrgentPostalTransfers,
    protected readonly bool $isFlagman,
    protected readonly bool $hasPostTerminal,
    protected readonly bool $isAutomated,
    protected readonly bool $isSecurity,
    protected readonly int $lockCode,
    protected readonly string $lockUa,
    protected readonly string $lockEn,
    protected readonly string $phone,
    protected readonly bool $isVpz,
    protected readonly int $merezaNumber,
    protected readonly int $techIndex,
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
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * {@inheritDoc}
   */
  public function getShortName(): string
  {
    return $this->shortName;
  }

  /**
   * {@inheritDoc}
   */
  public function getType(): string
  {
    return $this->type;
  }

  /**
   * {@inheritDoc}
   */
  public function getShortType(): string
  {
    return $this->shortType;
  }

  /**
   * {@inheritDoc}
   */
  public function getTypeAcronym(): string
  {
    return $this->typeAcronym;
  }

  /**
   * {@inheritDoc}
   */
  public function getParentId(): int
  {
    return $this->parentId;
  }

  /**
   * {@inheritDoc}
   */
  public function getCityId(): int
  {
    return $this->cityId;
  }

  /**
   * {@inheritDoc}
   */
  public function getCity(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"city$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getCityType(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"cityType$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getShortCityType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"shortCityType$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getPostIndex(): int
  {
    return $this->postIndex;
  }

  /**
   * {@inheritDoc}
   */
  public function getRegionId(): int
  {
    return $this->regionId;
  }

  /**
   * {@inheritDoc}
   */
  public function getRegion(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"region$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getDistrictId(): int
  {
    return $this->districtId;
  }

  /**
   * {@inheritDoc}
   */
  public function getDistrict(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"district$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getStreet(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"street$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getStreetType(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"streetType$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getHouseNumber(): string
  {
    return $this->houseNumber;
  }

  /**
   * {@inheritDoc}
   */
  public function getAddress(): string
  {
    return $this->address;
  }

  /**
   * {@inheritDoc}
   */
  public function getLongitude(): float
  {
    return $this->longitude;
  }

  /**
   * {@inheritDoc}
   */
  public function getLatitude(): float
  {
    return $this->latitude;
  }

  /**
   * {@inheritDoc}
   */
  public function isCash(): bool
  {
    return $this->isCash;
  }

  /**
   * {@inheritDoc}
   */
  public function isDhl(): bool
  {
    return $this->isDhl;
  }

  /**
   * {@inheritDoc}
   */
  public function isSmartbox(): bool
  {
    return $this->isSmartbox;
  }

  /**
   * {@inheritDoc}
   */
  public function isUrgentPostalTransfers(): bool
  {
    return $this->isUrgentPostalTransfers;
  }

  /**
   * {@inheritDoc}
   */
  public function isFlagman(): bool
  {
    return $this->isFlagman;
  }

  /**
   * {@inheritDoc}
   */
  public function hasPostTerminal(): bool
  {
    return $this->hasPostTerminal;
  }

  /**
   * {@inheritDoc}
   */
  public function isAutomated(): bool
  {
    return $this->isAutomated;
  }

  /**
   * {@inheritDoc}
   */
  public function isSecurity(): bool
  {
    return $this->isSecurity;
  }

  /**
   * {@inheritDoc}
   */
  public function getLockCode(): int
  {
    return $this->lockCode;
  }

  /**
   * {@inheritDoc}
   */
  public function getLock(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"lock$propSuffix"};
  }

  /**
   * {@inheritDoc}
   */
  public function getPhone(): string
  {
    return $this->phone;
  }

  /**
   * {@inheritDoc}
   */
  public function isVpz(): bool
  {
    return $this->isVpz;
  }

  /**
   * {@inheritDoc}
   */
  public function getMerezaNumber(): int
  {
    return $this->merezaNumber;
  }

  /**
   * {@inheritDoc}
   */
  public function getTechIndex(): int
  {
    return $this->techIndex;
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(?LanguagesEnumInterface $language = null): array
  {

    $data = [
      'id' => $this->getId(),
      'name' => $this->getName(),
      'short_name' => $this->getShortName(),
      'type' => $this->geTtype(),
      'short_type' => $this->getShortType(),
      'type_acronym' => $this->getTypeAcronym(),
      'parent_id' => $this->getParentId(),
      'city_id' => $this->getCityId(),
      'post_index' => $this->getpostIndex(),
      'region_id' => $this->getregionId(),
      'district_id' => $this->getdistrictId(),
      'house_number' => $this->gethouseNumber(),
      'address' => $this->getaddress(),
      'longitude' => $this->getlongitude(),
      'latitude' => $this->getlatitude(),
      'is_cash' => $this->isCash(),
      'is_dhl' => $this->isDhl(),
      'is_smartbox' => $this->isSmartbox(),
      'is_urgent_postal_transfers' => $this->isUrgentPostalTransfers(),
      'is_flagman' => $this->isFlagman(),
      'has_post_terminal' => $this->hasPostTerminal(),
      'is_automated' => $this->isAutomated(),
      'is_security' => $this->isSecurity(),
      'lock_code' => $this->getlockCode(),
      'phone' => $this->getphone(),
      'isVpz' => $this->isVpz(),
      'mereza_number' => $this->getmerezaNumber(),
      'tech_index' => $this->gettechIndex(),
    ];

    if (!$language) {
      $data['city_ua'] = $this->getCity();
      $data['city_en'] = $this->getCity(LanguagesEnum::EN);
      $data['city_type_ua'] = $this->getCityType();
      $data['city_type_en'] = $this->getCityType(LanguagesEnum::EN);
      $data['short_city_type_ua'] = $this->getShortCityType();
      $data['short_city_type_en'] = $this->getShortCityType(LanguagesEnum::EN);
      $data['region_ua'] = $this->getRegion();
      $data['region_en'] = $this->getRegion(LanguagesEnum::EN);
      $data['district_ua'] = $this->getDistrict();
      $data['district_en'] = $this->getDistrict(LanguagesEnum::EN);
      $data['street_ua'] = $this->getStreet();
      $data['street_en'] = $this->getStreet(LanguagesEnum::EN);
      $data['street_type_ua'] = $this->getStreetType();
      $data['street_type_en'] = $this->getStreetType(LanguagesEnum::EN);
      $data['lock_ua'] = $this->getLock();
      $data['lock_en'] = $this->getLock(LanguagesEnum::EN);
    }
    else {
      $data['city'] = $this->getCity($language);
      $data['city_type'] = $this->getCityType($language);
      $data['short_city_type'] = $this->getShortCityType($language);
      $data['region'] = $this->getRegion($language);
      $data['district'] = $this->getDistrict($language);
      $data['street'] = $this->getStreet($language);
      $data['street_type'] = $this->getStreetType($language);
      $data['lock'] = $this->getLock($language);
    }

    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public static function fromResponseEntry(array $entry): PostOfficeSettlementInterface {
    return new PostOfficeSettlement(
      id: (int) $entry['ID'],
      name: $entry['PO_LONG'],
      shortName: $entry['PO_SHORT'],
      type: $entry['TYPE_LONG'],
      shortType: $entry['TYPE_SHORT'],
      typeAcronym: $entry['TYPE_ACRONYM'],
      parentId: (int) $entry['PARENT_ID'],
      cityId: (int) $entry['CITY_ID'],
      cityUa: $entry['CITY_UA'],
      cityEn: $entry['CITY_EN'],
      cityTypeUa: $entry['CITYTYPE_UA'],
      cityTypeEn: $entry['CITYTYPE_EN'],
      shortCityTypeUa: $entry['SHORTCITYTYPE_UA'],
      shortCityTypeEn: $entry['SHORTCITYTYPE_EN'] ?? null,
      postIndex: (int) $entry['POSTINDEX'],
      regionId: (int) $entry['REGION_ID'],
      regionUa: $entry['REGION_UA'],
      regionEn: $entry['REGION_EN'],
      districtId: (int) $entry['DISTRICT_ID'],
      districtUa: $entry['DISTRICT_UA'],
      districtEn: $entry['DISTRICT_EN'],
      streetUa: $entry['STREET_UA'],
      streetEn: $entry['STREET_EN'],
      streetTypeUa: $entry['STREETTYPE_UA'],
      streetTypeEn: $entry['STREETTYPE_EN'],
      houseNumber: $entry['HOUSENUMBER'],
      address: $entry['ADDRESS'],
      longitude: (float) $entry['LONGITUDE'],
      latitude: (float) $entry['LATTITUDE'],
      isCash: (bool) $entry['IS_CASH'],
      isDhl: (bool) $entry['IS_DHL'],
      isSmartbox: (bool) $entry['IS_SMARTBOX'],
      isUrgentPostalTransfers: (bool) $entry['PELPEREKAZY'],
      isFlagman: (bool) $entry['IS_FLAGMAN'],
      hasPostTerminal: (bool) $entry['POSTTERMINAL'],
      isAutomated: (bool) $entry['IS_AUTOMATED'],
      isSecurity: (bool) $entry['IS_SECURITY'],
      lockCode: (int) $entry['LOCK_CODE'],
      lockUa: $entry['LOCK_UA'],
      lockEn: $entry['LOCK_EN'],
      phone: $entry['PHONE'],
      isVpz: (bool) $entry['ISVPZ'],
      merezaNumber: (int) $entry['MEREZA_NUMBER'],
      techIndex: (int) $entry['TECHINDEX'],
    );
  }

}
