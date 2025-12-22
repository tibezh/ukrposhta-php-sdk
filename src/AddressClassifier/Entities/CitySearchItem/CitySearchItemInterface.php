<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\CitySearchItem;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

interface CitySearchItemInterface extends EntityInterface
{

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getTypeId(): int;

    /**
     * @return string|null
     */
    public function getTypeName(): ?string;

    /**
     * @return int
     */
    public function getRegionId(): int;

    /**
     * @return string
     */
    public function getRegionName(): string;

    /**
     * @return int
     */
    public function getDistrictId(): int;

    /**
     * @return string
     */
    public function getDistrictName(): string;

    /**
     * @return array<string, mixed>
     *   Array version of the object.
     */
    public function toArray(): array;

}
