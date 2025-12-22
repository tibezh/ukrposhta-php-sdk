<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class PostOfficeSettlement implements PostOfficeSettlementInterface
{

    use StringMultilingualTrait;

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
     * @param StringMultilingualInterface $city
     * @param StringMultilingualInterface $cityType
     * @param StringMultilingualInterface $shortCityType
     * @param int $postIndex
     * @param int $regionId
     * @param StringMultilingualInterface $region
     * @param int $districtId
     * @param StringMultilingualInterface $district
     * @param StringMultilingualInterface $street
     * @param StringMultilingualInterface $streetType
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
     * @param StringMultilingualInterface $lock
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
        protected readonly StringMultilingualInterface $city,
        protected readonly StringMultilingualInterface $cityType,
        protected readonly StringMultilingualInterface $shortCityType,
        protected readonly int $postIndex,
        protected readonly int $regionId,
        protected readonly StringMultilingualInterface $region,
        protected readonly int $districtId,
        protected readonly StringMultilingualInterface $district,
        protected readonly StringMultilingualInterface $street,
        protected readonly StringMultilingualInterface $streetType,
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
        protected readonly StringMultilingualInterface $lock,
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
    public function getCity(): StringMultilingualInterface
    {
        return $this->city;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityType(): StringMultilingualInterface
    {
        return $this->cityType;
    }

    /**
     * {@inheritDoc}
     */
    public function getShortCityType(): StringMultilingualInterface
    {
        return $this->shortCityType;
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
    public function getRegion(): StringMultilingualInterface
    {
        return $this->region;
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
    public function getDistrict(): StringMultilingualInterface
    {
        return $this->district;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreet(): StringMultilingualInterface
    {
        return $this->street;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetType(): StringMultilingualInterface
    {
        return $this->streetType;
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
    public function getLock(): StringMultilingualInterface
    {
        return $this->lock;
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
        return [
          'id' => $this->getId(),
          'name' => $this->getName(),
          'short_name' => $this->getShortName(),
          'type' => $this->geTtype(),
          'short_type' => $this->getShortType(),
          'type_acronym' => $this->getTypeAcronym(),
          'parent_id' => $this->getParentId(),
          'city_id' => $this->getCityId(),
          'city' => $this->getCity()->getByLangOrArray($language),
          'city_type' => $this->getCityType()->getByLangOrArray($language),
          'short_city_type' => $this->getShortCityType()->getByLangOrArray($language),
          'post_index' => $this->getpostIndex(),
          'region_id' => $this->getregionId(),
          'region' => $this->getRegion()->getByLangOrArray($language),
          'district_id' => $this->getdistrictId(),
          'district' => $this->getDistrict()->getByLangOrArray($language),
          'street' => $this->getStreet()->getByLangOrArray($language),
          'street_type' => $this->getStreetType()->getByLangOrArray($language),
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
          'lock' => $this->getLock()->getByLangOrArray($language),
          'phone' => $this->getphone(),
          'isVpz' => $this->isVpz(),
          'mereza_number' => $this->getmerezaNumber(),
          'tech_index' => $this->gettechIndex(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): PostOfficeSettlementInterface
    {
        return new PostOfficeSettlement(
            id: (int) $entry['ID'],
            name: $entry['PO_LONG'],
            shortName: $entry['PO_SHORT'],
            type: $entry['TYPE_LONG'],
            shortType: $entry['TYPE_SHORT'],
            typeAcronym: $entry['TYPE_ACRONYM'],
            parentId: (int) $entry['PARENT_ID'],
            cityId: (int) $entry['CITY_ID'],
            city: self::getMultilingualStringFromEntryAndKey($entry, 'CITY_#lang'),
            cityType: self::getMultilingualStringFromEntryAndKey($entry, 'CITYTYPE_#lang'),
            shortCityType: self::getMultilingualStringFromEntryAndKey($entry, 'SHORTCITYTYPE_#lang'),
            postIndex: (int) $entry['POSTINDEX'],
            regionId: (int) $entry['REGION_ID'],
            region: self::getMultilingualStringFromEntryAndKey($entry, 'REGION_#lang'),
            districtId: (int) $entry['DISTRICT_ID'],
            district: self::getMultilingualStringFromEntryAndKey($entry, 'DISTRICT_#lang'),
            street: self::getMultilingualStringFromEntryAndKey($entry, 'STREET_#lang'),
            streetType: self::getMultilingualStringFromEntryAndKey($entry, 'STREETTYPE_#lang'),
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
            lock: self::getMultilingualStringFromEntryAndKey($entry, 'LOCK_#lang'),
            phone: $entry['PHONE'],
            isVpz: (bool) $entry['ISVPZ'],
            merezaNumber: (int) $entry['MEREZA_NUMBER'],
            techIndex: (int) $entry['TECHINDEX'],
        );
    }

}
