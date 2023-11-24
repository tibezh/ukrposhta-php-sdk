<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Tests\Utils\FakerGeneratorTrait;
use Ukrposhta\Tracking\TrackingStatus;
use Ukrposhta\Tracking\TrackingStatusInterface;

#[CoversClass(TrackingStatus::class)]
#[Small]
final class TrackingStatusTest extends TestCase {

  use FakerGeneratorTrait;

  protected array $fixturesData = [];

  protected function updateFixturesData(): void {
    $this->fixturesData = TrackingStatusHelper::getRandomTrackingStatusFixture();
  }

  public function testInterface(): void {
    $this->updateFixturesData();
    $trackingStatus = new TrackingStatus(...$this->fixturesData);
    $this->assertInstanceOf(TrackingStatusInterface::class, $trackingStatus);
  }

  public function testCanBeCreatedWithValidData(): void {
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

  public function testCannotBeCreatedWithNotValidArgumentData1(): void {
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus();
  }

  public function testCannotBeCreatedWithNotValidArgumentData2(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(barcode: $this->fixturesData['barcode']);
  }

  public function testCannotBeCreatedWithNotValidArgumentData3(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(
      barcode: $this->fixturesData['barcode'],
      step: $this->fixturesData['step']
    );
  }

  public function testCannotBeCreatedWithNotValidArgumentData4(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(
      barcode: $this->fixturesData['barcode'],
      step: $this->fixturesData['step'],
      date: $this->fixturesData['date']
    );
  }

  public function testCannotBeCreatedWithNotValidArgumentData5(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(
      barcode: $this->fixturesData['barcode'],
      step: $this->fixturesData['step'],
      date: $this->fixturesData['date'],
      eventId: $this->fixturesData['eventId']
    );
  }

  public function testCannotBeCreatedWithNotValidArgumentData6(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(
      barcode: $this->fixturesData['barcode'],
      step: $this->fixturesData['step'],
      date: $this->fixturesData['date'],
      eventId: $this->fixturesData['eventId'],
      eventName: $this->fixturesData['eventName']
    );
  }

  public function testCannotBeCreatedWithNotValidArgumentData7(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
    new TrackingStatus(
      barcode: $this->fixturesData['barcode'],
      step: $this->fixturesData['step'],
      date: $this->fixturesData['date'],
      eventId: $this->fixturesData['eventId'],
      eventName: $this->fixturesData['eventName'],
      country: $this->fixturesData['country']
    );
  }

  public function testCannotBeCreatedWithNotValidArgumentData8(): void {
    $this->updateFixturesData();
    $this->expectException(\ArgumentCountError::class);
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

  public function testCanBeCreatedWithRequiredArguments(): void {
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

  public function testCannotBeCreatedWithNotValidTypeData1(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['barcode'] = $this->fakerGenerator()->randomDigit();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData2(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['step'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData3(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['date'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData4(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['eventId'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData5(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['eventName'] = $this->fakerGenerator()->randomDigit();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData6(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['country'] = $this->fakerGenerator()->randomDigit();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData7(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['mailType'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData8(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['indexOrder'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData9(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['index'] = $this->fakerGenerator()->randomDigit();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData10(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['eventReason'] = $this->fakerGenerator()->randomDigit();
    new TrackingStatus(...$this->fixturesData);
  }

  public function testCannotBeCreatedWithNotValidTypeData11(): void {
    $this->expectException(\TypeError::class);
    $this->updateFixturesData();
    $this->fixturesData['eventReasonId'] = $this->fakerGenerator()->word();
    new TrackingStatus(...$this->fixturesData);
  }

}
