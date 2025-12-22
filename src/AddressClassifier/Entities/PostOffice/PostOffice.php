<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class PostOffice implements PostOfficeInterface
{

    use StringMultilingualTrait;

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
     * @param StringMultilingualInterface $lock
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
     * @param StringMultilingualInterface $serviceAreaCity
     * @param StringMultilingualInterface $serviceAreaCityType
     * @param StringMultilingualInterface $serviceAreaShortCityType
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
        protected readonly StringMultilingualInterface $lock,
        protected readonly int $lockCode,
        protected readonly int $regionId,
        protected readonly int $serviceAreaRegionId,
        protected readonly int $districtId,
        protected readonly int $serviceAreaDistrictId,
        protected readonly int $cityId,
        protected readonly string $cityType,
        protected readonly int $serviceAreaCityId,
        protected readonly StringMultilingualInterface $serviceAreaCity,
        protected readonly StringMultilingualInterface $serviceAreaCityType,
        protected readonly StringMultilingualInterface $serviceAreaShortCityType,
        protected readonly int $streetId,
        protected readonly int $parentId,
        protected readonly string $address,
        protected readonly string $phone,
        protected readonly float $longitude,
        protected readonly float $latitude,
        protected readonly bool $isVpz,
        protected readonly bool $isAvailable,
        protected readonly ?int $mrtps,
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
    public function getTypeAcronymName(): string
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
    public function getLock(): StringMultilingualInterface
    {
        return $this->lock;
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
    public function getServiceAreaCity(): StringMultilingualInterface
    {
        return $this->serviceAreaCity;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceAreaCityType(): StringMultilingualInterface
    {
        return $this->serviceAreaCityType;
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceAreaShortCityType(): StringMultilingualInterface
    {
        return $this->serviceAreaShortCityType;
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
    public function getPhoneNumber(): string
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
    public function getMrtps(): ?int
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
        return [
          'id' => $this->getId(),
          'code' => $this->getCode(),
          'name' => $this->getName(),
          'short_name' => $this->getShortName(),
          'type' => $this->getType(),
          'short_type' => $this->getShortType(),
          'type_acronym' => $this->getTypeAcronymName(),
          'post_index' => $this->getPostIndex(),
          'postcode' => $this->getPostCode(),
          'lock' => $this->getLock()->getByLangOrArray($language),
          'mereza_number' => $this->getMerezaNumber(),
          'lock_code' => $this->getLockCode(),
          'region_id' => $this->getRegionId(),
          'service_area_region_id' => $this->getServiceAreaRegionId(),
          'district_id' => $this->getDistrictId(),
          'service_area_district_id' => $this->getServiceAreaDistrictId(),
          'city_id' => $this->getCityId(),
          'city_type' => $this->getCityType(),
          'service_area_city_id' => $this->getServiceAreaCityId(),
          'service_area_city' => $this->getServiceAreaCity()->getByLangOrArray($language),
          'service_area_city_type' => $this->getServiceAreaCityType()->getByLangOrArray($language),
          'service_area_short_city_type' => $this->getServiceAreaShortCityType()->getByLangOrArray($language),
          'street_id' => $this->getStreetId(),
          'parent_id' => $this->getParentId(),
          'address' => $this->getAddress(),
          'phone' => $this->getPhoneNumber(),
          'longitude' => $this->getLongitude(),
          'latitude' => $this->getLatitude(),
          'is_vpz' => $this->isVpz(),
          'is_available' => $this->isAvailable(),
          'mrtps' => $this->getMrtps(),
          'tech_index' => $this->getTechIndex(),
          'is_delivery_possible' => $this->isDeliveryPossible(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): PostOfficeInterface
    {
        return new PostOffice(
            id: (int) $entry['ID'],
            code: (int) $entry['PO_CODE'],
            name: $entry['PO_LONG'],
            shortName: $entry['PO_SHORT'],
            type: $entry['TYPE_LONG'],
            typeShort: $entry['TYPE_SHORT'],
            typeAcronym: $entry['TYPE_ACRONYM'],
            postIndex: (int) $entry['POSTINDEX'],
            postCode: (int) $entry['POSTCODE'],
            merezaNumber: (int) $entry['MEREZA_NUMBER'],
            lock: self::getMultilingualStringFromEntryAndKey($entry, 'POLOCK_#lang'),
            lockCode: (int) $entry['LOCK_CODE'],
            regionId: (int) $entry['POREGION_ID'],
            serviceAreaRegionId: (int) $entry['PDREGION_ID'],
            districtId: (int) $entry['PODISTRICT_ID'],
            serviceAreaDistrictId: (int) $entry['PDDISTRICT_ID'],
            cityId: (int) $entry['POCITY_ID'],
            cityType: $entry['CITYTYPE_UA'],
            serviceAreaCityId: (int) $entry['PDCITY_ID'],
            serviceAreaCity: self::getMultilingualStringFromEntryAndKey($entry, 'PDCITY_#lang'),
            serviceAreaCityType: self::getMultilingualStringFromEntryAndKey($entry, 'PDCITYTYPE_#lang'),
            serviceAreaShortCityType: self::getMultilingualStringFromEntryAndKey($entry, 'SHORTPDCITYTYPE_#lang'),
            streetId: (int) $entry['POSTREET_ID'],
            parentId: (int) $entry['PARENT_ID'],
            address: $entry['ADDRESS'],
            phone: $entry['PHONE'],
            longitude: (float) $entry['LONGITUDE'],
            latitude: (float) $entry['LATTITUDE'],
            isVpz: (bool) $entry['ISVPZ'],
            isAvailable: (bool) $entry['AVALIBLE'],
            mrtps: isset($entry['MRTPS']) ? (int) $entry['MRTPS'] : null,
            techIndex: (int) $entry['TECHINDEX'],
            isDeliveryPossible: $entry['IS_NODISTRICT'] == 0,
        );
    }

}
