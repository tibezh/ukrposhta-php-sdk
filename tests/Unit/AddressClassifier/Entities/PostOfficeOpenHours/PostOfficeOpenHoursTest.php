<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\PostOfficeOpenHours;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHours;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(PostOfficeOpenHours::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class PostOfficeOpenHoursTest extends TestCase
{
    private PostOfficeOpenHours $postOfficeOpenHours;
    private StringMultilingualInterface $dayOfWeekMock;
    private StringMultilingualInterface $shortDayOfWeekMock;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->dayOfWeekMock = $this->createMock(StringMultilingualInterface::class);
        $this->dayOfWeekMock->method('getByLangOrArray')->willReturn('Monday');

        $this->shortDayOfWeekMock = $this->createMock(StringMultilingualInterface::class);
        $this->shortDayOfWeekMock->method('getByLangOrArray')->willReturn('Mon');

        $this->postOfficeOpenHours = new PostOfficeOpenHours(
            id: 1,
            type: 'Main',
            name: 'Main Post Office',
            shortName: 'MPO',
            lockReason: 'Holiday',
            dayOfWeekNumber: 1,
            dayOfWeek: $this->dayOfWeekMock,
            shortDayOfWeek: $this->shortDayOfWeekMock,
            intervalType: 'Normal',
            parentPostOfficeId: 2,
            openingTime: '09:00',
            closingTime: '17:00',
            workComment: 'Open all day'
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->postOfficeOpenHours->getPostOfficeId());
        $this->assertEquals('Main', $this->postOfficeOpenHours->getPostOfficeType());
        $this->assertEquals('Main Post Office', $this->postOfficeOpenHours->getPostOfficeName());
        $this->assertEquals('MPO', $this->postOfficeOpenHours->getPostOfficeShortName());
        $this->assertEquals('Holiday', $this->postOfficeOpenHours->getLockReason());
        $this->assertEquals(1, $this->postOfficeOpenHours->getDayOfWeekNumber());
        $this->assertEquals($this->dayOfWeekMock, $this->postOfficeOpenHours->getDayOfWeek());
        $this->assertEquals($this->shortDayOfWeekMock, $this->postOfficeOpenHours->getShortDayOfWeek());
        $this->assertEquals('Normal', $this->postOfficeOpenHours->getIntervalType());
        $this->assertEquals(2, $this->postOfficeOpenHours->getParentPostOfficeId());
        $this->assertEquals('09:00', $this->postOfficeOpenHours->getOpeningTime());
        $this->assertEquals('17:00', $this->postOfficeOpenHours->getClosingTime());
        $this->assertEquals('Open all day', $this->postOfficeOpenHours->getWorkComment());
    }

    public function testToArray(): void
    {
        $expectedArray = [
            'id' => 1,
            'type' => 'Main',
            'name' => 'Main Post Office',
            'short_name' => 'MPO',
            'lock_reason' => 'Holiday',
            'days_of_week_number' => 1,
            'days_of_week' => 'Monday',
            'short_days_of_week' => 'Mon',
            'interval_type' => 'Normal',
            'parent_post_office_id' => 2,
            'opening_time' => '09:00',
            'closing_time' => '17:00',
            'work_comment' => 'Open all day',
        ];
        $this->assertEquals($expectedArray, $this->postOfficeOpenHours->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'id' => '2',
            'POSTOFFICE_TYPE' => 'Branch',
            'FULLNAME' => 'Main Post Office',
            'SHORTNAME' => 'MPO',
            'LOCK_REASON' => 'Holiday',
            'DAYOFWEEK_NUM' => '1',
            'DAYOFWEEK_UA' => 'Понеділок',
            'DAYOFWEEK_EN' => 'Monday',
            'DAYOFWEEK_SHORTNAME_UA' => 'Пн',
            'DAYOFWEEK_SHORTNAME_EN' => 'Mon',
            'INTERVALTYPE' => '3',
            'POSTOFFICE_PARENT' => '5',
            'TFROM' => '09:00',
            'TTO' => '17:00',
            'WORKCOMMENT' => 'work comment',
        ];
        $postOfficeOpenHours = PostOfficeOpenHours::fromResponseEntry($entry);

        $this->assertInstanceOf(PostOfficeOpenHours::class, $postOfficeOpenHours);
        $this->assertEquals(2, $postOfficeOpenHours->getPostOfficeId());
        $this->assertEquals('Branch', $postOfficeOpenHours->getPostOfficeType());
        $this->assertEquals('Main Post Office', $postOfficeOpenHours->getPostOfficeName());
        $this->assertEquals('MPO', $postOfficeOpenHours->getPostOfficeShortName());
        $this->assertEquals(1, $postOfficeOpenHours->getDayOfWeekNumber());
        $this->assertEquals(
            ['ua' => 'Понеділок', 'en' => 'Monday'],
            $postOfficeOpenHours->getDayOfWeek()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'Пн', 'en' => 'Mon'],
            $postOfficeOpenHours->getShortDayOfWeek()->getByLangOrArray()
        );
        $this->assertEquals(3, $postOfficeOpenHours->getIntervalType());
        $this->assertEquals(5, $postOfficeOpenHours->getParentPostOfficeId());
        $this->assertEquals('09:00', $postOfficeOpenHours->getOpeningTime());
        $this->assertEquals('17:00', $postOfficeOpenHours->getClosingTime());
        $this->assertEquals('work comment', $postOfficeOpenHours->getWorkComment());
    }
}
