<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 *
 */
interface PostOfficeKoatuuInterface extends EntityInterface
{

    /**
     * Gets Post Code value.
     *
     * @return int
     *   Post code of the Post Office.
     */
    public function getPostCode(): int;

    /**
     * @return int
     */
    public function getPostIndex(): int;

    /**
     * Gets City ID.
     *
     * @return int
     *   City ID of the Post Office.
     */
    public function getCityId(): int;

    /**
     * Gets City Koatuu.
     *
     * @return int
     *   City Koatuu of the Post Office.
     */
    public function getCityKoatuu(): int;

    /**
     * Gets City Katottg.
     *
     * @return int
     *   City Katottg of the Post Office.
     */
    public function getCityKatottg(): int;

    /**
     * @return int
     */
    public function getCityVpzId(): int;

    /**
     * Gets city type name.
     *
     * @return StringMultilingualInterface
     *   City type name of the Post office as multilingual string.
     */
    public function getCityTypeName(): StringMultilingualInterface;

    /**
     * Gets City VPZ name.
     *
     * @return StringMultilingualInterface
     *   City VPZ name of the Post Office as multilingual string.
     */
    public function getCityVpzName(): StringMultilingualInterface;

    /**
     * Gets City VPZ Koatuu.
     *
     * @return int
     *   City VPZ Koatuu of the Post Office.
     */
    public function getCityVpzKoatuu(): int;

    /**
     * Gets Street VPZ ID.
     *
     * @return int
     *   Street VPZ ID of the Post Office.
     */
    public function getStreetVpzId(): int;

    /**
     * Gets Street VPZ name.
     *
     * @return StringMultilingualInterface
     *   Street name of the Post Office as multilingual string.
     */
    public function getStreetVpzName(): StringMultilingualInterface;

    /**
     * Gets House number.
     *
     * @return string|null
     *   House number of the Post Office.
     */
    public function getHouseNumber(): ?string;

    /**
     * Gets unique identifier.
     *
     * @return int
     *   ID of the Post Office Koatuu.
     */
    public function getPostOfficeId(): int;

    /**
     * Gets Post Office name.
     *
     * @return StringMultilingualInterface
     *   Post Office name as multilingual string.
     */
    public function getPostOfficeName(): StringMultilingualInterface;

    /**
     * Gets Post Office details.
     *
     * @return StringMultilingualInterface
     *   Post Office details as multilingual string.
     */
    public function getPostOfficeDetails(): StringMultilingualInterface;

    /**
     * Get phone number.
     *
     * @return string
     *   Phone number of the Post Office.
     */
    public function getPhoneNumber(): string;

    /**
     * Gets longitude.
     *
     * @return float
     *   Longitude of the Post Office.
     */
    public function getLongitude(): float;

    /**
     * Gets latitude.
     *
     * @return float
     *   Latitude of the Post Office.
     */
    public function getLatitude(): float;

    /**
     * Gets Type ID.
     *
     * @return int
     *   Type ID of the Post Office.
     */
    public function getTypeId(): int;

    /**
     * Gets Type acronym name.
     *
     * @return string
     *   Type acronym name of the Post Office.
     */
    public function getTypeAcronymName(): string;

    /**
     * Gets long type name.
     *
     * @return string
     *   Long type name of the Post Office.
     */
    public function getTypeLongName(): string;

    /**
     * Gets post terminal availability status.
     *
     * @return bool
     *   True value if the Post Office has post terminal.
     */
    public function hasPostTerminal(): bool;

    /**
     * Automated status.
     *
     * @return bool
     *   True value if the Post Office is automated.
     */
    public function isAutomated(): bool;

    /**
     * Security status.
     *
     * @return bool
     *   True value if the Post Office is a closed-type department.
     */
    public function isSecurity(): bool;

    /**
     * Gets lock code.
     *
     * @return int
     *   Lock code of the Post Office.
     */
    public function getLockCode(): int;

    /**
     * Gets lock name.
     *
     * @return StringMultilingualInterface
     *   Lock name on provided language of the Post Office as multilingual string.
     */
    public function getLockName(): StringMultilingualInterface;

    /**
     * Gets an associative array version of the Post Office Koatuu.
     *
     * @param LanguagesEnumInterface|null $language
     *   Language of the value to return, NULL by default which returns all values.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(?LanguagesEnumInterface $language = null): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): PostOfficeKoatuuInterface;

}
