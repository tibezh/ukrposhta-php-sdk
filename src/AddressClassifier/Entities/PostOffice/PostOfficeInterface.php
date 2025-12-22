<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOffice;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 * Provides required methods for PostOffice entity.
 */
interface PostOfficeInterface extends EntityInterface
{

    /**
     * Gets unique identifier.
     *
     * @return int
     *   ID of the Post Office.
     */
    public function getId(): int;

    /**
     * Gets code.
     *
     * @return int
     *   Code of the Post Office.
     */
    public function getCode(): int;

    /**
     * Gets long name.
     *
     * @return string
     *   Long name of the Post Office.
     */
    public function getName(): string;

    /**
     * Gets short name.
     *
     * @return string
     *   Short name of the Post Office.
     */
    public function getShortName(): string;

    /**
     * Gets type.
     *
     * Warning! UA language only.
     *
     * @return string
     *   Type of the Post Office.
     */
    public function getType(): string;

    /**
     * Gets short type.
     *
     * Warning! UA language only.
     *
     * @return string
     *   Short type of the Post Office.
     */
    public function getShortType(): string;

    /**
     * Gets type acronym name.
     *
     * @return string
     *   Type acronym of the Post Office.
     */
    public function getTypeAcronymName(): string;

    /**
     * Gets post index.
     *
     * @return int
     *   Post index of the Post Office.
     */
    public function getPostIndex(): int;

    /**
     * Gets post code.
     *
     * @return int
     *   Post code of the Post Office.
     */
    public function getPostCode(): int;

    /**
     * Gets mereza number.
     *
     * @return int
     *   Mereza number of the Post Office.
     */
    public function getMerezaNumber(): int;

    /**
     * Gets lock description.
     *
     * @return StringMultilingualInterface
     *   Lock description of the Post Office.
     */
    public function getLock(): StringMultilingualInterface;

    /**
     * Gets lock code.
     *
     * @return int
     *   Lock code of the Post Office.
     */
    public function getLockCode(): int;

    /**
     * Gets region ID.
     *
     * @return int
     *   Region ID of the Post Office.
     */
    public function getRegionId(): int;

    /**
     * Gets service area region ID.
     *
     * @return int
     *   Service area region ID of the Post Office.
     */
    public function getServiceAreaRegionId(): int;

    /**
     * Gets district ID.
     *
     * @return int
     *   District ID of the Post Office.
     */
    public function getDistrictId(): int;

    /**
     * Gets service area district ID.
     *
     * @return int
     *   Service area district ID of the Post Office.
     */
    public function getServiceAreaDistrictId(): int;

    /**
     * Gets city ID.
     *
     * @return int
     *   City ID of the Post Office.
     */
    public function getCityId(): int;

    /**
     * Gets city type.
     *
     * Warning! UA language only.
     *
     * @return string
     *   City type of the Post Office.
     */
    public function getCityType(): string;

    /**
     * Gets service area city ID.
     *
     * @return int
     *   Service area city ID of the Post Office.
     */
    public function getServiceAreaCityId(): int;

    /**
     * Gets service area city name.
     *
     * @return StringMultilingualInterface
     *   Service area city name of the Post Office.
     */
    public function getServiceAreaCity(): StringMultilingualInterface;

    /**
     * Gets service area city type.
     *
     * @return StringMultilingualInterface
     *   Service area city type of the Post Office.
     */
    public function getServiceAreaCityType(): StringMultilingualInterface;

    /**
     * Gets service area short city type.
     *
     * @return StringMultilingualInterface
     *   Service area short city type of the Post Office, can be null for specific languages.
     */
    public function getServiceAreaShortCityType(): StringMultilingualInterface;

    /**
     * Gets street ID.
     *
     * @return int
     *   Street ID of the Post Office.
     */
    public function getStreetId(): int;

    /**
     * Gets parent ID.
     *
     * Identifier of the parent Post Office that was find by post index.
     *
     * @return int
     *   Parent ID of the Post Office.
     */
    public function getParentId(): int;

    /**
     * Gets address
     *
     * @return string
     *   Address of the Post Office.
     */
    public function getAddress(): string;

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
     * Gets vpz sign status.
     *
     * Post Office can also be sorting.
     *
     * @return bool
     *   True value if the Post Office has vpz sign, otherwise false.
     */
    public function isVpz(): bool;

    /**
     * Gets available status.
     *
     * @return bool
     *   True value if the Post Office is available, otherwise false.
     */
    public function isAvailable(): bool;

    /**
     * Gets mrtps code.
     *
     * The code indicating the location of the mobile post office in the settlement:
     * 1 – absent;
     * 2 – in the premises of the village council;
     * 3 – in the premises of the former VZP;
     * 4 – in the cultural center;
     * 5 – in the library;
     * 6 – in the store;
     * 7 – at a gas station;
     * 8 – in the sorting center;
     * 9 - other.
     *
     * @todo probably can be defined via enum.
     *
     * @return int|null
     *   Mrtps code of the Post Office.
     */
    public function getMrtps(): ?int;

    /**
     * Gets internal technical index.
     *
     * @return int
     *   Internal technical index of the Post Office.
     */
    public function getTechIndex(): int;

    /**
     * Gets delivery possible status.
     *
     * @return bool
     *   True value if possible delivery to the Post Office, otherwise false.
     */
    public function isDeliveryPossible(): bool;

    /**
     * Gets an associative array version of the Post Office.
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
    public static function fromResponseEntry(array $entry): PostOfficeInterface;

}
