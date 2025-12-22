<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 *
 */
interface PostOfficeOpenHoursInterface extends EntityInterface
{

    /**
     * Gets Post Office ID.
     *
     * @return int
     *   ID of the related Post Office.
     */
    public function getPostOfficeId(): int;

    /**
     * Gets Post Office type.
     *
     * @return string
     *   Type of the related Post Office.
     */
    public function getPostOfficeType(): string;

    /**
     * Gets Post Office name (full).
     *
     * @return string
     *   Name of the Post Office.
     */
    public function getPostOfficeName(): string;

    /**
     * Gets short name of the Post Office.
     *
     * @return string
     *   Short name of the Post Office.
     */
    public function getPostOfficeShortName(): string;

    /**
     * Gets lock reason information.
     *
     * @return string
     *   Lock reason of the Post Office.
     */
    public function getLockReason(): string;

    /**
     * Gets working day number.
     *
     * @return int
     *   Working day of week number.
     */
    public function getDayOfWeekNumber(): int;

    /**
     * Gets working day name.
     *
     * @return StringMultilingualInterface
     *   Working day of week name.
     */
    public function getDayOfWeek(): StringMultilingualInterface;

    /**
     * Gets short name of the working day.
     *
     * @return StringMultilingualInterface
     *   Short name of the working day, can be null for specific languages.
     */
    public function getShortDayOfWeek(): StringMultilingualInterface;

    /**
     * Gets interval type.
     *
     * @return string
     *   Interval type value.
     */
    public function getIntervalType(): string;

    /**
     * Parent (central) Post Office ID.
     *
     * @return int
     *   ID of the parent (central) Post Office.
     */
    public function getParentPostOfficeId(): int;

    /**
     * Post Office opening time.
     *
     * @return string
     *   Opening time of the Post Office.
     */
    public function getOpeningTime(): string;

    /**
     * Post Office closing time.
     *
     * @return string
     *   Closing time of the Post Office.
     */
    public function getClosingTime(): string;

    /**
     * Post Office work comments.
     *
     * @return string
     *   Work comments of the Post Office.
     */
    public function getWorkComment(): string;

    /**
     * Gets an associative array version of the Post Office Open Hours.
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
    public static function fromResponseEntry(array $entry): PostOfficeOpenHoursInterface;

}
