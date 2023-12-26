<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class PostOffice implements PostOfficeInterface {

  /**
   * PostOffice constructor.
   *
   * @param int $id
   *   ID value.
   * @param int $code
   *   Code value.
   * @param string $name
   *   Long name in UA language.
   * @param string $shortName
   *   Short name in UA language.
   * @param string $type
   *   Short name in UA language.
   * @param string $typeShort
   *   Sort type in UA language.
   * @param string $typeAcronym
   *   Type acronym.
   * @param int $postIndex
   *   Post index.
   * @param int $postCode
   *   Post code.
   * @param int $merezaNumber
   *   Mereza number.
   * @param string $lockUa
   *   Lock in UA language.
   * @param string $lockEn
   *   Lock in EN language.
   * @param int $lockCode
   *   Lock code.
   * @param int $regionId
   *   Region ID.
   * @param int $serviceAreaRegionId
   *   Service area region ID.
   * @param int $districtId
   *   District ID.
   * @param int $serviceAreaDistrictId
   *   Service area district ID.
   * @param int $cityId
   *   City ID.
   * @param string $cityType
   *   City type in UA language.
   * @param int $serviceAreaCityId
   *   Service area city ID.
   * @param string $serviceAreaCityUa
   *   Service area city name in UA language.
   * @param string $serviceAreaCityEn
   *   Service area city name in EN language.
   * @param string $serviceAreaCityTypeUa
   *   Service area city type name in UA language.
   * @param string $serviceAreaCityTypeEn
   *   Service area city type name in EN language.
   * @param string $serviceAreaShortCityTypeUa
   *   Service area short city name in UA language.
   * @param string|null $serviceAreaShortCityTypeEn
   *   Service area short city name in EN language, can be null.
   * @param int $streetId
   *   Street ID.
   * @param int $parentId
   *   Parent ID.
   * @param string $address
   *   Address value.
   * @param string $phone
   *   Phone number.
   * @param float $longitude
   *   Post Office longitude.
   * @param float $latitude
   *   Post Office latitude.
   * @param bool $isVpz
   *   Is vpz status.
   * @param bool $isAvailable
   *   Is available status.
   * @param int $mrtps
   *   Mrtps code.
   * @param int $techIndex
   *   Technical index.
   * @param bool $isDeliveryPossible
   *   Is possible delivery to the post office flag.
   */
  public function __construct(
    protected readonly int $id,
    protected readonly int $code,
    protected readonly string $name,
    protected readonly string $shortName,
    protected readonly string $type,
    protected readonly string $typeShort,
    protected readonly string $typeAcronym,
    protected readonly int $postIndex,
    protected readonly int $postCode,
    protected readonly int $merezaNumber,
    protected readonly string $lockUa,
    protected readonly string $lockEn,
    protected readonly int $lockCode,
    protected readonly int $regionId,
    protected readonly int $serviceAreaRegionId,
    protected readonly int $districtId,
    protected readonly int $serviceAreaDistrictId,
    protected readonly int $cityId,
    protected readonly string $cityType,
    protected readonly int $serviceAreaCityId,
    protected readonly string $serviceAreaCityUa,
    protected readonly string $serviceAreaCityEn,
    protected readonly string $serviceAreaCityTypeUa,
    protected readonly string $serviceAreaCityTypeEn,
    protected readonly string $serviceAreaShortCityTypeUa,
    protected readonly ?string $serviceAreaShortCityTypeEn,
    protected readonly int $streetId,
    protected readonly int $parentId,
    protected readonly string $address,
    protected readonly string $phone,
    protected readonly float $longitude,
    protected readonly float $latitude,
    protected readonly bool $isVpz,
    protected readonly bool $isAvailable,
    protected readonly int $mrtps,
    protected readonly int $techIndex,
    protected readonly bool $isDeliveryPossible
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
  public function getCode(): int
  {
    return $this->code;
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
    return $this->typeShort;
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
  public function getPostIndex(): int
  {
    return $this->postIndex;
  }

  /**
   * {@inheritDoc}
   */
  public function getPostCode(): int
  {
    return $this->postCode;
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
  public function getLock(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"lock{$propSuffix}"};
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
  public function getRegionId(): int
  {
    return $this->regionId;
  }

  /**
   * {@inheritDoc}
   */
  public function getServiceAreaRegionId(): int
  {
    return $this->serviceAreaRegionId;
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
  public function getServiceAreaDistrictId(): int
  {
    return $this->serviceAreaDistrictId;
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
  public function getCityType(): string
  {
    return $this->cityType;
  }

  /**
   * {@inheritDoc}
   */
  public function getServiceAreaCityId(): int
  {
    return $this->serviceAreaCityId;
  }

  /**
   * {@inheritDoc}
   */
  public function getServiceAreaCity(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"serviceAreaCity{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getServiceAreaCityType(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"serviceAreaCityType{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getServiceAreaShortCityType(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"serviceAreaShortCityType{$propSuffix}"} ?? null;
  }

  /**
   * {@inheritDoc}
   */
  public function getStreetId(): int
  {
    return $this->streetId;
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
  public function getAddress(): string
  {
    return $this->address;
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
  public function isVpz(): bool
  {
    return $this->isVpz;
  }

  /**
   * {@inheritDoc}
   */
  public function isAvailable(): bool
  {
    return $this->isAvailable;
  }

  /**
   * {@inheritDoc}
   */
  public function getMrtps(): int
  {
    return $this->mrtps;
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
  public function isDeliveryPossible(): bool
  {
    return $this->isDeliveryPossible;
  }

  /**
   * {@inheritDoc}
   */
  public function toArray(?LanguagesEnumInterface $language = null): array
  {
    $data = [
      'id' => $this->getId(),
      'code' => $this->getCode(),
      'name' => $this->getName(),
      'short_name' => $this->getShortName(),
      'type' => $this->getType(),
      'short_type' => $this->getShortType(),
      'type_acronym' => $this->getTypeAcronym(),
      'post_index' => $this->getPostIndex(),
      'post_code' => $this->getPostCode(),
      'mereza_number' => $this->getMerezaNumber(),
      'lock_code' => $this->getLockCode(),
      'region_id' => $this->getRegionId(),
      'service_area_region_id' => $this->getServiceAreaRegionId(),
      'district_id' => $this->getDistrictId(),
      'service_area_district_id' => $this->getServiceAreaDistrictId(),
      'city_id' => $this->getCityId(),
      'city_type' => $this->getCityType(),
      'service_area_city_id' => $this->getServiceAreaCityId(),
      'street_id' => $this->getStreetId(),
      'parent_id' => $this->getParentId(),
      'address' => $this->getAddress(),
      'phone' => $this->getPhone(),
      'longitude' => $this->getLongitude(),
      'latitude' => $this->getLatitude(),
      'is_vpz' => $this->isVpz(),
      'is_available' => $this->isAvailable(),
      'mrtps' => $this->getMrtps(),
      'tech_index' => $this->getTechIndex(),
      'is_delivery_possible' => $this->isDeliveryPossible(),
    ];

    if (!$language) {
      $data['lock_ua'] = $this->getLock();
      $data['lock_en'] = $this->getLock(LanguagesEnum::EN);
      $data['service_area_city_ua'] = $this->getServiceAreaCity();
      $data['service_area_city_en'] = $this->getServiceAreaCity(LanguagesEnum::EN);
      $data['service_area_city_type_ua'] = $this->getServiceAreaCityType();
      $data['service_area_city_type_en'] = $this->getServiceAreaCityType(LanguagesEnum::EN);
      $data['service_area_short_city_type_ua'] = $this->getServiceAreaShortCityType();
      $data['service_area_short_city_type_en'] = $this->getServiceAreaShortCityType(LanguagesEnum::EN);
    }
    else {
      $data['lock'] = $this->getLock($language);
      $data['service_area_city'] = $this->getServiceAreaCity($language);
      $data['service_area_city_type'] = $this->getServiceAreaCityType($language);
      $data['service_area_short_city_type'] = $this->getServiceAreaShortCityType($language);
    }

    return $data;
  }

}
