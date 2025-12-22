<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

/**
 * Address information entity.
 */
class Address implements AddressInterface
{

    /**
     * Address constructor.
     *
     * @param int $regionId
     * @param string $regionName
     * @param int $districtId
     * @param string $districtName
     * @param int $cityId
     * @param string $cityName
     * @param int|null $cityTypeId
     * @param string|null $cityTypeName
     * @param int $streetId
     * @param string $streetName
     * @param int $streetTypeId
     * @param string $streetTypeName
     * @param string|null $streetShorTypeName
     * @param int $postCode
     * @param string $houseNumber
     */
    public function __construct(
        protected readonly int $regionId,
        protected readonly string $regionName,
        protected readonly int $districtId,
        protected readonly string $districtName,
        protected readonly int $cityId,
        protected readonly string $cityName,
        protected readonly ?int $cityTypeId,
        protected readonly ?string $cityTypeName,
        protected readonly int $streetId,
        protected readonly string $streetName,
        protected readonly int $streetTypeId,
        protected readonly string $streetTypeName,
        protected readonly ?string $streetShorTypeName,
        protected readonly int $postCode,
        protected readonly string $houseNumber
    ) {
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
    public function getRegionName(): string
    {
        return $this->regionName;
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
    public function getDistrictName(): string
    {
        return $this->districtName;
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
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityTypeId(): ?int
    {
        return $this->cityTypeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getCityTypeName(): ?string
    {
        return $this->cityTypeName;
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
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetTypeId(): int
    {
        return $this->streetTypeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetTypeName(): string
    {
        return $this->streetTypeName;
    }

    /**
     * {@inheritDoc}
     */
    public function getStreetShortTypeName(): ?string
    {
        return $this->streetShorTypeName;
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
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
          'region_id' => $this->getRegionId(),
          'region_name' => $this->getRegionName(),
          'district_id' => $this->getDistrictId(),
          'district_name' => $this->getDistrictName(),
          'city_id' => $this->getCityId(),
          'city_name' => $this->getCityName(),
          'city_type_id' => $this->getCityTypeId(),
          'city_type_name' => $this->getCityTypeName(),
          'street_id' => $this->getStreetId(),
          'street_name' => $this->getStreetName(),
          'street_type_id' => $this->getStreetTypeId(),
          'street_type_name' => $this->getStreetTypeName(),
          'street_short_type_name' => $this->getStreetShortTypeName(),
          'postcode' => $this->getPostCode(),
          'house_number' => $this->getHouseNumber(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): AddressInterface
    {
        return new Address(
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
            districtId: (int) $entry['DISTRICT_ID'],
            districtName: $entry['DISTRICT_NAME'],
            cityId: (int) $entry['CITY_ID'],
            cityName: $entry['CITY_NAME'],
            cityTypeId: isset($entry['CTIYTYPE_ID']) ? (int) $entry['CTIYTYPE_ID'] : null,
            cityTypeName: $entry['CITYTYPE_NAME'] ?? null,
            streetId: (int) $entry['STREET_ID'],
            streetName: $entry['STREET_NAME'],
            streetTypeId: (int) $entry['STREETTYPE_ID'],
            streetTypeName: $entry['STREETTYPE_NAME'],
            streetShorTypeName: $entry['SHORTSTREETTYPE_NAME'] ?? null,
            postCode: (int) $entry['POSTCODE'],
            houseNumber: $entry['HOUSENUMBER']
        );
    }

}
