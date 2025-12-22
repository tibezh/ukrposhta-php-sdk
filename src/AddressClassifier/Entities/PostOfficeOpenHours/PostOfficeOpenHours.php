<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class PostOfficeOpenHours implements PostOfficeOpenHoursInterface
{

    use StringMultilingualTrait;

    /**
     * PostOfficeOpenHours constructor.
     *
     * @param int $id
     * @param string $type
     * @param string $name
     * @param string $shortName
     * @param string $lockReason
     * @param int $dayOfWeekNumber
     * @param StringMultilingualInterface $dayOfWeek
     * @param StringMultilingualInterface $shortDayOfWeek
     * @param string $intervalType
     * @param int $parentPostOfficeId
     * @param string $openingTime
     * @param string $closingTime
     * @param string $workComment
     */
    public function __construct(
        protected readonly int $id,
        protected readonly string $type,
        protected readonly string $name,
        protected readonly string $shortName,
        protected readonly string $lockReason,
        protected readonly int $dayOfWeekNumber,
        protected readonly StringMultilingualInterface $dayOfWeek,
        protected readonly StringMultilingualInterface $shortDayOfWeek,
        protected readonly string $intervalType,
        protected readonly int $parentPostOfficeId,
        protected readonly string $openingTime,
        protected readonly string $closingTime,
        protected readonly string $workComment
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostOfficeShortName(): string
    {
        return $this->shortName;
    }

    /**
     * {@inheritDoc}
     */
    public function getLockReason(): string
    {
        return $this->lockReason;
    }

    /**
     * {@inheritDoc}
     */
    public function getDayOfWeekNumber(): int
    {
        return $this->dayOfWeekNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function getDayOfWeek(): StringMultilingualInterface
    {
        return $this->dayOfWeek;
    }

    /**
     * {@inheritDoc}
     */
    public function getShortDayOfWeek(): StringMultilingualInterface
    {
        return $this->shortDayOfWeek;
    }

    /**
     * {@inheritDoc}
     */
    public function getIntervalType(): string
    {
        return $this->intervalType;
    }

    /**
     * {@inheritDoc}
     */
    public function getParentPostOfficeId(): int
    {
        return $this->parentPostOfficeId;
    }

    /**
     * {@inheritDoc}
     */
    public function getOpeningTime(): string
    {
        return $this->openingTime;
    }

    /**
     * {@inheritDoc}
     */
    public function getClosingTime(): string
    {
        return $this->closingTime;
    }

    /**
     * {@inheritDoc}
     */
    public function getWorkComment(): string
    {
        return $this->workComment;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(?LanguagesEnumInterface $language = null): array
    {
        return [
          'id' => $this->getPostOfficeId(),
          'type' => $this->getPostOfficeType(),
          'name' => $this->getPostOfficeName(),
          'short_name' => $this->getPostOfficeShortName(),
          'lock_reason' => $this->getLockReason(),
          'days_of_week_number' => $this->getDayOfWeekNumber(),
          'days_of_week' => $this->getDayOfWeek()->getByLangOrArray($language),
          'short_days_of_week' => $this->getShortDayOfWeek()->getByLangOrArray($language),
          'interval_type' => $this->getIntervalType(),
          'parent_post_office_id' => $this->getParentPostOfficeId(),
          'opening_time' => $this->getOpeningTime(),
          'closing_time' => $this->getClosingTime(),
          'work_comment' => $this->getWorkComment(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): PostOfficeOpenHoursInterface
    {
        return new PostOfficeOpenHours(
            id: (int) $entry['id'],
            type: $entry['POSTOFFICE_TYPE'],
            name: $entry['FULLNAME'],
            shortName: $entry['SHORTNAME'],
            lockReason: $entry['LOCK_REASON'],
            dayOfWeekNumber: (int) $entry['DAYOFWEEK_NUM'],
            dayOfWeek: self::getMultilingualStringFromEntryAndKey($entry, 'DAYOFWEEK_#lang'),
            shortDayOfWeek: self::getMultilingualStringFromEntryAndKey($entry, 'DAYOFWEEK_SHORTNAME_#lang'),
            intervalType: $entry['INTERVALTYPE'],
            parentPostOfficeId: (int) $entry['POSTOFFICE_PARENT'],
            openingTime: $entry['TFROM'],
            closingTime: $entry['TTO'],
            workComment: $entry['WORKCOMMENT']
        );
    }

}
