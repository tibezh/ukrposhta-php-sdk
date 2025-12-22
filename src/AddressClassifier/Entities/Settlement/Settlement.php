<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Settlement;

/**
 *
 */
class Settlement implements SettlementInterface
{

    /**
     * Settlement contructor.
     *
     * @param int $postCode
     * @param int $regionId
     * @param string $regionName
     * @param int $districtId
     * @param string $districtName
     * @param int $cityId
     * @param string $cityName
     * @param string|null $cityTypeName
     */
    public function __construct(
        protected readonly int $postCode,
        protected readonly int $regionId,
        protected readonly string $regionName,
        protected readonly int $districtId,
        protected readonly string $districtName,
        protected readonly int $cityId,
        protected readonly string $cityName,
        protected readonly ?string $cityTypeName
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
    public function getCityName(): ?string
    {
        return $this->cityName;
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
    public function toArray(): array
    {
        return [
          'postcode' => $this->getPostCode(),
          'region_id' => $this->getRegionId(),
          'region_name' => $this->getRegionName(),
          'district_id' => $this->getDistrictId(),
          'district_name' => $this->getDistrictName(),
          'city_id' => $this->getCityId(),
          'city_name' => $this->getCityName(),
          'city_type_name' => $this->getCityTypeName(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): SettlementInterface
    {
        return new Settlement(
            postCode: (int) $entry['POSTCODE'],
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
            districtId: (int) $entry['DISTRICT_ID'],
            districtName: $entry['DISTRICT_NAME'],
            cityId: (int) $entry['CITY_ID'],
            cityName: $entry['CITY_NAME'],
            cityTypeName: $entry['CITYTYPE_NAME'] ?? null
        );
    }

}
