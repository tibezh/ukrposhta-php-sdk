<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Settlement;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 *
 */
interface SettlementInterface extends EntityInterface
{

    /**
     * Gets post code.
     *
     * @return int
     *   Post code of the Settlement.
     */
    public function getPostCode(): int;

    /**
     * Gets Region ID.
     *
     * @return int
     *   Region ID of the Settlement.
     */
    public function getRegionId(): int;

    /**
     * Gets Region name.
     *
     * @return string
     *   Region name of the Settlement.
     */
    public function getRegionName(): string;

    /**
     * Gets District ID.
     *
     * @return int
     *   District ID of the Settlement.
     */
    public function getDistrictId(): int;

    /**
     * Gets District name.
     *
     * @return string
     *   District name of the Settlement.
     */
    public function getDistrictName(): string;

    /**
     * Gets City ID.
     *
     * @return int
     *   City ID of the Settlement.
     */
    public function getCityId(): int;

    /**
     * Gets City name.
     *
     * @return string|null
     *   City name of the Settlement, can be null for specific languages.
     */
    public function getCityName(): ?string;

    /**
     * Gets City type name.
     *
     * @return string|null
     *   City type name of the Settlement.
     */
    public function getCityTypeName(): ?string;

    /**
     * Gets an associative array version of the Settlement.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): SettlementInterface;

}
