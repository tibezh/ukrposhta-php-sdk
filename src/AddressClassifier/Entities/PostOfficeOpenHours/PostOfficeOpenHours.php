<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class PostOfficeOpenHours implements PostOfficeOpenHoursInterface
{

  /**
   * PostOfficeOpenHours constructor.
   *
   * @param int $id
   * @param string $type
   * @param string $name
   * @param string $shortName
   * @param string $lockReason
   * @param int $dayOfWeekNumber
   * @param string $dayOfWeekUa
   * @param string $dayOfWeekEn
   * @param string $shortDayOfWeekUa
   * @param string|null $shortDayOfWeekEn
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
    protected readonly string $dayOfWeekUa,
    protected readonly string $dayOfWeekEn,
    protected readonly string $shortDayOfWeekUa,
    protected readonly ?string $shortDayOfWeekEn,
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
  public function getDayOfWeek(LanguagesEnumInterface $language = LanguagesEnum::UA): string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"dayOfWeek{$propSuffix}"};
  }

  /**
   * {@inheritDoc}
   */
  public function getShortDayOfWeek(LanguagesEnumInterface $language = LanguagesEnum::UA): ?string
  {
    $propSuffix = $language->propSuffix();
    return $this->{"shortDayOfWeek{$propSuffix}"} ?? null;
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
    $data = [
      'id' => $this->getPostOfficeId(),
      'type' => $this->getPostOfficeType(),
      'name' => $this->getPostOfficeName(),
      'short_name' => $this->getPostOfficeShortName(),
      'lock_reason' => $this->getLockReason(),
      'days_of_week_number' => $this->getDayOfWeekNumber(),
      'interval_type' => $this->getIntervalType(),
      'parent_post_office_id' => $this->getParentPostOfficeId(),
      'opening_time' => $this->getOpeningTime(),
      'closing_time' => $this->getClosingTime(),
      'work_comment' => $this->getWorkComment(),
    ];

    if (!$language) {
      $data['days_of_week_ua'] = $this->getDayOfWeek();
      $data['days_of_week_en'] = $this->getDayOfWeek(LanguagesEnum::EN);
      $data['short_days_of_week_ua'] = $this->getShortDayOfWeek();
      $data['short_days_of_week_en'] = $this->getShortDayOfWeek(LanguagesEnum::EN);
    }
    else {
      $data['days_of_week'] = $this->getDayOfWeek($language);
      $data['short_days_of_week'] = $this->getShortDayOfWeek($language);
    }

    return $data;
  }

}
