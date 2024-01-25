<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\DistrictSearchItem;

/**
 *
 */
class DistrictSearchItem implements DistrictSearchItemInterface
{

    /**
     * DistrictSearchItem constructor.
     *
     * @param int $id
     * @param string $name
     * @param int $regionId
     * @param string $regionName
     */
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly int $regionId,
        protected readonly string $regionName
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
    public function toArray(): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName(),
          'region_id' => $this->getRegionId(),
          'region_name' => $this->getRegionName(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): DistrictSearchItemInterface
    {
        return new DistrictSearchItem(
            id: (int) $entry['DISTRICT_ID'],
            name: $entry['DISTRICT_NAME'],
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
        );
    }

}
