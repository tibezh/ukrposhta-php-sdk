<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Tracking\TrackingStatus;
use Ukrposhta\Tracking\TrackingStatusInterface;

#[CoversClass(TrackingStatus::class)]
#[Small]
final class TrackingStatusTest extends TestCase
{

    /**
     * @var array<string, mixed>
     */
    protected array $fixturesData = [];

    protected function updateFixturesData(): void
    {
        $this->fixturesData = TrackingStatusHelper::getRandomTrackingStatusFixture();
    }

    public function testInterface(): void
    {
        $this->updateFixturesData();
        $trackingStatus = new TrackingStatus(...$this->fixturesData);
        $this->assertInstanceOf(TrackingStatusInterface::class, $trackingStatus);
    }

    public function testCanBeCreatedWithValidData(): void
    {
        $this->updateFixturesData();
        $trackingStatus = new TrackingStatus(...$this->fixturesData);
        $this->assertSame($this->fixturesData['barcode'], $trackingStatus->getBarcode());
        $this->assertSame($this->fixturesData['step'], $trackingStatus->getStep());
        $this->assertSame($this->fixturesData['date'], $trackingStatus->getDate());
        $this->assertSame($this->fixturesData['index'], $trackingStatus->getIndex());
        $this->assertSame($this->fixturesData['name'], $trackingStatus->getName());
        $this->assertSame($this->fixturesData['eventId'], $trackingStatus->getEventId());
        $this->assertSame($this->fixturesData['eventName'], $trackingStatus->getEventName());
        $this->assertSame($this->fixturesData['country'], $trackingStatus->getCountry());
        $this->assertSame($this->fixturesData['eventReason'], $trackingStatus->getEventReason());
        $this->assertSame($this->fixturesData['eventReasonId'], $trackingStatus->getEventReasonId());
        $this->assertSame($this->fixturesData['mailType'], $trackingStatus->getMailType());
        $this->assertSame($this->fixturesData['indexOrder'], $trackingStatus->getIndexOrder());
    }

    public function testCannotBeCreatedWithNotValidArgumentData1(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus();
    }

    public function testCannotBeCreatedWithNotValidArgumentData2(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(barcode: $this->fixturesData['barcode']);
    }

    public function testCannotBeCreatedWithNotValidArgumentData3(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step']
        );
    }

    public function testCannotBeCreatedWithNotValidArgumentData4(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date']
        );
    }

    public function testCannotBeCreatedWithNotValidArgumentData5(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date'],
            eventId: $this->fixturesData['eventId']
        );
    }

    public function testCannotBeCreatedWithNotValidArgumentData6(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date'],
            eventId: $this->fixturesData['eventId'],
            eventName: $this->fixturesData['eventName']
        );
    }

    public function testCannotBeCreatedWithNotValidArgumentData7(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date'],
            eventId: $this->fixturesData['eventId'],
            eventName: $this->fixturesData['eventName'],
            country: $this->fixturesData['country']
        );
    }

    public function testCannotBeCreatedWithNotValidArgumentData8(): void
    {
        $this->updateFixturesData();
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date'],
            eventId: $this->fixturesData['eventId'],
            eventName: $this->fixturesData['eventName'],
            country: $this->fixturesData['country'],
            mailType: $this->fixturesData['mailType']
        );
    }

    public function testCanBeCreatedWithRequiredArguments(): void
    {
        $this->updateFixturesData();
        $this->expectNotToPerformAssertions();
        new TrackingStatus(
            barcode: $this->fixturesData['barcode'],
            step: $this->fixturesData['step'],
            date: $this->fixturesData['date'],
            name: $this->fixturesData['name'],
            eventId: $this->fixturesData['eventId'],
            eventName: $this->fixturesData['eventName'],
            country: $this->fixturesData['country'],
            mailType: $this->fixturesData['mailType'],
            indexOrder: $this->fixturesData['indexOrder']
        );
    }

    public function testCannotBeCreatedWithNotValidTypeData1(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['barcode'] = 123;
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData2(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['step'] = 'step2';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData3(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['date'] = 'date3';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData4(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['eventId'] = 'eventId4';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData5(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['eventName'] = 123450;
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData6(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['country'] = 0123456;
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData7(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['mailType'] = 'mailType7';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData8(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['indexOrder'] = 'indexOrder8';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData9(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['index'] = 123456789999;
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData10(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['eventReason'] = 101011123;
        new TrackingStatus(...$this->fixturesData);
    }

    public function testCannotBeCreatedWithNotValidTypeData11(): void
    {
        $this->expectException(\TypeError::class);
        $this->updateFixturesData();
        $this->fixturesData['eventReasonId'] = 'eventReasonId11';
        new TrackingStatus(...$this->fixturesData);
    }

    public function testToArray(): void
    {
        $this->updateFixturesData();
        $trackingStatus = new TrackingStatus(...$this->fixturesData);
        $trackingStatusArray = $trackingStatus->toArray();
        $this->assertSame($this->fixturesData['barcode'], $trackingStatusArray['barcode']);
        $this->assertSame($this->fixturesData['step'], $trackingStatusArray['step']);
        $this->assertSame($this->fixturesData['date'], $trackingStatusArray['date']);
        $this->assertSame($this->fixturesData['index'], $trackingStatusArray['index']);
        $this->assertSame($this->fixturesData['name'], $trackingStatusArray['name']);
        $this->assertSame($this->fixturesData['eventId'], $trackingStatusArray['event_id']);
        $this->assertSame($this->fixturesData['eventName'], $trackingStatusArray['event_name']);
        $this->assertSame($this->fixturesData['country'], $trackingStatusArray['country']);
        $this->assertSame($this->fixturesData['eventReason'], $trackingStatusArray['event_reason']);
        $this->assertSame($this->fixturesData['eventReasonId'], $trackingStatusArray['event_reason_id']);
        $this->assertSame($this->fixturesData['mailType'], $trackingStatusArray['mail_type']);
        $this->assertSame($this->fixturesData['indexOrder'], $trackingStatusArray['index_order']);
    }

}
