<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Address;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 * Provides required methods for Address entity.
 */
interface AddressInterface extends EntityInterface
{

    /**
     * Gets Address Region ID.
     *
     * @return int
     *   The Region ID of the Address.
     */
    public function getRegionId(): int;

    /**
     * Gets Address Region name.
     *
     * @return string
     *   The Region name of the Address.
     */
    public function getRegionName(): string;

    /**
     * Gets Address District ID.
     *
     * @return int
     *   The District ID of the Address.
     */
    public function getDistrictId(): int;

    /**
     * Gets Address District name.
     *
     * @return string
     *   The District name of the Address.
     */
    public function getDistrictName(): string;

    /**
     * Gets Address City ID.
     *
     * @return int
     *   The City ID of the Address.
     */
    public function getCityId(): int;

    /**
     * Gets Address City name.
     *
     * @return string
     *   The City name of the Address.
     */
    public function getCityName(): string;

    /**
     * Gets Address City type ID.
     *
     * @return int|null
     *   The City type ID of the Address, can be null for specific languages.
     */
    public function getCityTypeId(): ?int;

    /**
     * Gets Address City type name.
     *
     * @return string|null
     *   The City type name of the Address, can be null for specific languages.
     */
    public function getCityTypeName(): ?string;

    /**
     * Gets Address Street ID.
     *
     * @return int
     *   The Street ID of the address.
     */
    public function getStreetId(): int;

    /**
     * Gets Address Street name.
     *
     * @return string
     *   The Street name of the Address.
     */
    public function getStreetName(): string;

    /**
     * Gets Address Street type ID.
     *
     * @return int
     *   The Street type ID of the Address.
     */
    public function getStreetTypeId(): int;

    /**
     * Gets Address Street type name.
     *
     * @return string
     *   The Street type name of the address.
     */
    public function getStreetTypeName(): string;

    /**
     * Gets Address Street short type name.
     *
     * @return string|null
     *   The Street short type name of the Address, can be null for specific languages.
     */
    public function getStreetShortTypeName(): ?string;

    /**
     * Gets Address Post Code.
     *
     * @return int
     *   The Post Code of the Address.
     */
    public function getPostCode(): int;

    /**
     * Gets Address House number.
     *
     * @return string
     *   The House number of the Address.
     */
    public function getHouseNumber(): string;

    /**
     * Gets an associative array version of the Address.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): AddressInterface;

}
