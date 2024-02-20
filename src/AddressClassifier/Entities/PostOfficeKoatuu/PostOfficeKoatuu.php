<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu;

use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class PostOfficeKoatuu implements PostOfficeKoatuuInterface
{

    use StringMultilingualTrait;

    /**
     * PostOfficeKoatuu constructor.
     *
     * @param int $postCode
     * @param int $postIndex
     * @param int $cityId
     * @param int $cityKoatuu
     * @param int $cityKatottg
     * @param int $cityVpzId
     * @param StringMultilingualInterface $cityTypeName
     * @param StringMultilingualInterface $cityVpzName
     * @param int $cityVpzKoatuu
     * @param int $streetVpzId
     * @param StringMultilingualInterface $streetVpzName
     * @param string|null $houseNumber
     * @param int $postOfficeId
     * @param StringMultilingualInterface $postOfficeName
     * @param StringMultilingualInterface $postOfficeDetails
     * @param string $phoneNumber
     * @param float $longitude
     * @param float $latitude
     * @param int $typeId
     * @param string $typeAcronymName
     * @param string $typeLongName
     * @param bool $hasPostTerminal
     * @param bool $isAutomated
     * @param bool $isSecurity
     * @param int $lockCode
     * @param StringMultilingualInterface $lockName
     */
    public function __construct(
        protected readonly int $postCode,
        protected readonly int $postIndex,
        protected readonly int $cityId,
        protected readonly int $cityKoatuu,
        protected readonly int $cityKatottg,
        protected readonly int $cityVpzId,
        protected readonly StringMultilingualInterface $cityTypeName,
        protected readonly StringMultilingualInterface $cityVpzName,
        protected readonly int $cityVpzKoatuu,
        protected readonly int $streetVpzId,
        protected readonly StringMultilingualInterface $streetVpzName,
        protected readonly ?string $houseNumber,
        protected readonly int $postOfficeId,
        protected readonly StringMultilingualInterface $postOfficeName,
        protected readonly StringMultilingualInterface $postOfficeDetails,
        protected readonly string $phoneNumber,
        protected readonly float $longitude,
        protected readonly float $latitude,
        protected readonly int $typeId,
        protected readonly string $typeAcronymName,
        protected readonly string $typeLongName,
        protected readonly bool $hasPostTerminal,
        protected readonly bool $isAutomated,
        protected readonly bool $isSecurity,
        protected readonly int $lockCode,
        protected readonly StringMultilingualInterface $lockName,
    ) {
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
    public function getPostIndex(): int
    {
        return $this->postIndex;
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
    public function getCityKoatuu(): int
    {
        return $this->cityKoatuu;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityKatottg(): int
    {
        return $this->cityKatottg;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityVpzId(): int
    {
        return $this->cityVpzId;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityTypeName(): StringMultilingualInterface
    {
        return $this->cityTypeName;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityVpzName(): StringMultilingualInterface
    {
        return $this->cityVpzName;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityVpzKoatuu(): int
    {
        return $this->cityVpzKoatuu;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetVpzId(): int
    {
        return $this->streetVpzId;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetVpzName(LanguagesEnumInterface $language = LanguagesEnum::UA): StringMultilingualInterface
    {
        return $this->streetVpzName;
    }

    /**
     * {@inheritDoc}
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeId(): int
    {
        return $this->postOfficeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeName(): StringMultilingualInterface
    {
        return $this->postOfficeName;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeDetails(): StringMultilingualInterface
    {
        return $this->postOfficeDetails;
    }

    /**
     * {@inheritDoc}
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeAcronymName(): string
    {
        return $this->typeAcronymName;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeLongName(): string
    {
        return $this->typeLongName;
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
    public function getLockName(): StringMultilingualInterface
    {
        return $this->lockName;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(?LanguagesEnumInterface $language = null): array
    {
        return [
          'post_code' => $this->getPostCode(),
          'post_index' => $this->getPostIndex(),
          'city_id' => $this->getCityId(),
          'city_koatuu' => $this->getCityKoatuu(),
          'city_katottg' => $this->getCityKatottg(),
          'city_vpz_id' => $this->getCityVpzId(),
          'city_type_name' => $this->getCityTypeName()->getByLangOrArray($language),
          'city_vpz_name' => $this->getCityVpzName()->getByLangOrArray($language),
          'city_vpz_koatuu' => $this->getCityVpzKoatuu(),
          'street_vpz_id' => $this->getStreetVpzId(),
          'street_vpz_name' => $this->getStreetVpzName()->getByLangOrArray($language),
          'house_number' => $this->getHouseNumber(),
          'post_office_id' => $this->getPostOfficeId(),
          'post_office_name' => $this->getPostOfficeName()->getByLangOrArray($language),
          'post_office_details' => $this->getPostOfficeDetails()->getByLangOrArray($language),
          'phone_number' => $this->getPhoneNumber(),
          'longitude' => $this->getLongitude(),
          'latitude' => $this->getLatitude(),
          'type_id' => $this->getTypeId(),
          'type_acronym_name' => $this->getTypeAcronymName(),
          'type_long_name' => $this->getTypeLongName(),
          'has_post_terminal' => $this->hasPostTerminal(),
          'is_automated' => $this->isAutomated(),
          'is_security' => $this->isSecurity(),
          'lock_code' => $this->getLockCode(),
          'lock_name' => $this->getLockName()->getByLangOrArray($language),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): PostOfficeKoatuuInterface
    {
        return new PostOfficeKoatuu(
            postCode: (int) $entry['POSTCODE'],
            postIndex: (int) $entry['POSTINDEX'],
            cityId: (int) $entry['CITY_ID'],
            cityKoatuu: (int) $entry['CITY_KOATUU'],
            cityKatottg: (int) $entry['CITY_KATOTTG'],
            cityVpzId: (int) $entry['CITY_VPZ_ID'],
            cityTypeName: self::getMultilingualStringFromEntryAndKey($entry, 'CITY_#lang_TYPE'),
            cityVpzName: self::getMultilingualStringFromEntryAndKey($entry, 'CITY_#lang_VPZ'),
            cityVpzKoatuu: (int) $entry['CITY_VPZ_KOATUU'],
            streetVpzId: (int) $entry['STREET_ID_VPZ'],
            streetVpzName: self::getMultilingualStringFromEntryAndKey($entry, 'STREET_#lang_VPZ'),
            houseNumber: $entry['HOUSENUMBER'],
            postOfficeId: (int) $entry['POSTOFFICE_ID'],
            postOfficeName: self::getMultilingualStringFromEntryAndKey($entry, 'POSTOFFICE_#lang'),
            postOfficeDetails: self::getMultilingualStringFromEntryAndKey($entry, 'POSTOFFICE_#lang_DETAILS'),
            phoneNumber: $entry['PHONE'],
            longitude: (float) $entry['LONGITUDE'],
            latitude: (float) $entry['LATTITUDE'],
            typeId: (int) $entry['TYPE_ID'],
            typeAcronymName: $entry['TYPE_ACRONYM'],
            typeLongName: $entry['TYPE_LONG'],
            hasPostTerminal: (bool) $entry['POSTTERMINAL'],
            isAutomated: (bool) $entry['ISAUTOMATED'],
            isSecurity: (bool) $entry['IS_SECURITY'],
            lockCode: (int) $entry['LOCK_CODE'],
            lockName: self::getMultilingualStringFromEntryAndKey($entry, 'LOCK_#lang'),
        );
    }

}
