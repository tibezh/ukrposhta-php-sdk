<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\StreetSearchItem;

/**
 *
 */
class StreetSearchItem implements StreetSearchItemInterface
{

    /**
     * StreetSearchItem constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $typeId
     * @param string $typeName
     * @param string $shortTypeName
     * @param int $regionId
     * @param string $regionName
     * @param int $districtId
     * @param string $districtName
     * @param int $cityId
     * @param string $cityName
     * @param int $cityTypeId
     * @param string|null $cityTypeName
     */
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly int $typeId,
        protected readonly string $typeName,
        protected readonly string $shortTypeName,
        protected readonly int $regionId,
        protected readonly string $regionName,
        protected readonly int $districtId,
        protected readonly string $districtName,
        protected readonly int $cityId,
        protected readonly string $cityName,
        protected readonly int $cityTypeId,
        protected readonly ?string $cityTypeName
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    /**
     * @inheritDoc
     */
    public function getTypeName(): string
    {
        return $this->typeName;
    }

    /**
     * @inheritDoc
     */
    public function getShortTypeName(): string
    {
        return $this->shortTypeName;
    }

    /**
     * @inheritDoc
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    /**
     * @inheritDoc
     */
    public function getRegionName(): string
    {
        return $this->regionName;
    }

    /**
     * @inheritDoc
     */
    public function getDistrictId(): int
    {
        return $this->districtId;
    }

    /**
     * @inheritDoc
     */
    public function getDistrictName(): string
    {
        return $this->districtName;
    }

    /**
     * @inheritDoc
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @inheritDoc
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @inheritDoc
     */
    public function getCityTypeId(): int
    {
        return $this->cityTypeId;
    }

    /**
     * @inheritDoc
     */
    public function getCityTypeName(): ?string
    {
        return $this->cityTypeName;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName(),
          'type_id' => $this->getTypeId(),
          'type_name' => $this->getTypeName(),
          'short_type_name' => $this->getShortTypeName(),
          'region_id' => $this->getRegionId(),
          'region_name' => $this->getRegionName(),
          'district_id' => $this->getDistrictId(),
          'district_name' => $this->getDistrictName(),
          'city_id' => $this->getCityId(),
          'city_name' => $this->getCityName(),
          'city_type_id' => $this->getCityTypeId(),
          'city_type_name' => $this->getCityTypeName(),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromResponseEntry(array $entry): StreetSearchItem
    {
        return new StreetSearchItem(
            id: (int) $entry['STREET_ID'],
            name: $entry['STREET_NAME'],
            typeId: (int) $entry['STREETTYPE_ID'],
            typeName: $entry['STREETTYPE_NAME'],
            shortTypeName: $entry['SHORTSTREETTYPE_NAME'],
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
            districtId: (int) $entry['DISTRICT_ID'],
            districtName: $entry['DISTRICT_NAME'],
            cityId: (int) $entry['CITY_ID'],
            cityName: $entry['CITY_NAME'],
            cityTypeId: (int) $entry['CITYTYPE_ID'],
            cityTypeName: $entry['CITYTYPE_NAME'],
        );
    }

}
