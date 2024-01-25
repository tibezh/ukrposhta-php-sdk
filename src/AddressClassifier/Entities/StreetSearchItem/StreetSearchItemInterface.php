<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\StreetSearchItem;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 *
 */
interface StreetSearchItemInterface extends EntityInterface
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
     * @return string
     */
    public function getTypeName(): string;

    /**
     * @return string
     */
    public function getShortTypeName(): string;

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
     * @return int
     */
    public function getCityId(): int;

    /**
     * @return string
     */
    public function getCityName(): string;

    /**
     * @return int
     */
    public function getCityTypeId(): int;

    /**
     * @return string|null
     */
    public function getCityTypeName(): ?string;

    /**
     * @return array<string, mixed>
     *   Array version of the object.
     */
    public function toArray(): array;

}
