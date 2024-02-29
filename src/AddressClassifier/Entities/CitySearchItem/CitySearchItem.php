<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\CitySearchItem;

/**
 *
 */
class CitySearchItem implements CitySearchItemInterface
{
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly int $typeId,
        protected readonly ?string $typeName,
        protected readonly int $regionId,
        protected readonly string $regionName,
        protected readonly int $districtId,
        protected readonly string $districtName
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
    public function getTypeName(): ?string
    {
        return $this->typeName;
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
    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName(),
          'type_id' => $this->getTypeId(),
          'type_name' => $this->getTypeName(),
          'region_id' => $this->getRegionId(),
          'region_name' => $this->getRegionName(),
          'district_id' => $this->getDistrictId(),
          'district_name' => $this->getDistrictName(),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function fromResponseEntry(array $entry): CitySearchItemInterface
    {
        return new CitySearchItem(
            id: (int) $entry['CITY_ID'],
            name: $entry['CITY_NAME'],
            typeId: (int) $entry['CITYTYPE_ID'],
            typeName: $entry['CITYTYPE_NAME'],
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
            districtId: (int) $entry['DISTRICT_ID'],
            districtName: $entry['DISTRICT_NAME']
        );
    }

}
