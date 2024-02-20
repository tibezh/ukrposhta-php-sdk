<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 * Provides required methods for PostOfficeSettlement entity.
 */
interface PostOfficeSettlementInterface extends \Ukrposhta\AddressClassifier\Entities\EntityInterface
{

    /**
     * Gets ID.
     *
     * @return int
     *   ID of the Post Office Settlement.
     */
    public function getId(): int;

    /**
     * Gets name.
     *
     * @return string
     *   Name of the Post Office Settlement.
     */
    public function getName(): string;

    /**
     * Gets short name.
     *
     * @return string
     *   Short name of the Post Office Settlement.
     */
    public function getShortName(): string;

    /**
     * Gets type.
     *
     * @return string
     *   Type of the Post Office Settlement.
     */
    public function getType(): string;

    /**
     * Gets short type.
     *
     * @return string
     *   Short type of the Post Office Settlement.
     */
    public function getShortType(): string;

    /**
     * Gets acronym type.
     *
     * @return string
     *   Acronym type of the Post Office Settlement.
     */
    public function getTypeAcronym(): string;

    /**
     * Gets parent ID.
     *
     * @return int
     *   Parent ID of the Post Office Settlement.
     */
    public function getParentId(): int;

    /**
     * Gets city ID.
     *
     * @return int
     *   City ID of the Post Office Settlement.
     */
    public function getCityId(): int;

    /**
     * Gets city name.
     *
     * @return StringMultilingualInterface
     *   City name on provided language of the Post Office Settlement.
     */
    public function getCity(): StringMultilingualInterface;

    /**
     * Gets city type.
     *
     * @return StringMultilingualInterface
     *   City type on provided language of the Post Office Settlement.
     */
    public function getCityType(): StringMultilingualInterface;

    /**
     * Gets short city type.
     *
     * @return StringMultilingualInterface
     *   Short city type on provided language of the Post Office Settlement, can be null.
     */
    public function getShortCityType(): StringMultilingualInterface;

    /**
     * Gets post index.
     *
     * @return int
     *   Post index of the Post Office Settlement.
     */
    public function getPostIndex(): int;

    /**
     * Gets region ID.
     *
     * @return int
     *   Region ID.
     */
    public function getRegionId(): int;

    /**
     * Gets region name.
     *
     * @return StringMultilingualInterface
     *   Region name on provided language of the Post Office Settlement.
     */
    public function getRegion(): StringMultilingualInterface;

    /**
     * Gets district ID.
     *
     * @return int
     *   District ID of the Post Office Settlement.
     */
    public function getDistrictId(): int;

    /**
     * Gets district name.
     *
     * @return StringMultilingualInterface
     *   District name on provided language of the Post Office Settlement.
     */
    public function getDistrict(): StringMultilingualInterface;

    /**
     * Gets street name.
     *
     * @return StringMultilingualInterface
     *   Street name on provided language of the Post Office Settlement.
     */
    public function getStreet(): StringMultilingualInterface;

    /**
     * Gets street type.
     *
     * @return StringMultilingualInterface
     *   Street type on provided language of the Post Office Settlement.
     */
    public function getStreetType(): StringMultilingualInterface;

    /**
     * Gets house number.
     *
     * @return string
     *   House number of the Post Office Settlement.
     */
    public function getHouseNumber(): string;

    /**
     * Gets full address.
     *
     * @return string
     *   Full address of the Post Office Settlement.
     */
    public function getAddress(): string;

    /**
     * Gets longitude.
     *
     * @return float
     *   Longitude of the Post Office Settlement.
     */
    public function getLongitude(): float;

    /**
     * Gets latitude.
     *
     * @return float
     *   Latitude of the Post Office Settlement.
     */
    public function getLatitude(): float;

    /**
     * Gets withdraw cache status.
     *
     * @return bool
     *   True value if the Post Office Settlement has the ability to withdraw cash.
     */
    public function isCash(): bool;

    /**
     * Gets sending via DHL status.
     *
     * @return bool
     *   True value if the Post Office Settlement has the possibility of sending via DHL.
     */
    public function isDhl(): bool;

    /**
     * Gets Smartbox service status.
     *
     * @return bool
     *   True value if the Post Office Settlement has the ability to use the SMARTBOX service.
     */
    public function isSmartbox(): bool;

    /**
     * Gets urgent postal transfers status.
     *
     * @return bool
     *   True value if the Post Office Settlement supports urgent postal transfers.
     */
    public function isUrgentPostalTransfers(): bool;

    /**
     * Gets flagship status.
     *
     * @return bool
     *   True if the Post Office Settlement is flagship department.
     */
    public function isFlagman(): bool;

    /**
     * Gets post terminal availability status.
     *
     * @return bool
     *   True value if the Post Office Settlement has post terminal.
     */
    public function hasPostTerminal(): bool;

    /**
     * Automated status.
     *
     * @return bool
     *   True value if the Post Office Settlement is automated.
     */
    public function isAutomated(): bool;

    /**
     * Security status.
     *
     * @return bool
     *   True value if the Post Office Settlement is a closed-type department.
     */
    public function isSecurity(): bool;

    /**
     * Gets lock code.
     *
     * @return int
     *   Lock code of the Post Office Settlement.
     */
    public function getLockCode(): int;

    /**
     * Gets lock name.
     *
     * @return StringMultilingualInterface
     *   Lock name on provided language of the Post Office Settlement.
     */
    public function getLock(): StringMultilingualInterface;

    /**
     * Gets phone number.
     *
     * @return string
     *   Phone number of the Post Office Settlement.
     */
    public function getPhone(): string;

    /**
     * Gets vpz sign status.
     *
     * Post Office can also be sorting.
     *
     * @return bool
     *   True value if the Post Office has vpz sign, otherwise false.
     */
    public function isVpz(): bool;

    /**
     * Gets mereza number.
     *
     * @return int
     *   Mereza number of the Post Office.
     */
    public function getMerezaNumber(): int;

    /**
     * Gets internal technical index.
     *
     * @return int
     *   Internal technical index of the Post Office.
     */
    public function getTechIndex(): int;

    /**
     * Gets an associative array version of the Post Office Settlement.
     *
     * @param LanguagesEnumInterface|null $language
     *   Language of the value to return, NULL by default which returns all values.
     *
     * @return array<string, mixed>
     *   Array version of the object.
     */
    public function toArray(?LanguagesEnumInterface $language = null): array;

    /**
     * Gets Post Office Settlement object from response entry.
     *
     * @param array<string|mixed> $entry
     *   Entry from a response.
     *
     * @return PostOfficeSettlementInterface
     *   Post Office Settlement object.
     */
    public static function fromResponseEntry(array $entry): PostOfficeSettlementInterface;

}
