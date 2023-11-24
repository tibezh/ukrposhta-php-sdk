<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Tracking\TrackingStatus;
use Ukrposhta\Tracking\TrackingStatusCollection;
use Ukrposhta\Tracking\TrackingStatusCollectionInterface;

#[CoversClass(TrackingStatusCollection::class)]
#[UsesClass(TrackingStatus::class)]
#[Small]
final class TrackingStatusCollectionTest extends TestCase {

  public function testInterface(): void {
    $collection = new TrackingStatusCollection();
    $this->assertInstanceOf(TrackingStatusCollectionInterface::class, $collection);
  }

  public function testConstructor(): void {
    $trackingStatus = new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture());
    $collection = new TrackingStatusCollection([$trackingStatus]);
    $this->assertSame($trackingStatus, $collection->current());
  }

  public function testAddFunction(): void {
    $trackingStatus = new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture());
    $collection = (new TrackingStatusCollection());
    $collection->add($trackingStatus);
    $this->assertSame($trackingStatus, $collection->current());
  }

  public function testAll(): void {
    $count = mt_rand(2, 10);
    $trackingStatuses = [];
    for ($i = 0; $i < $count; $i++) {
      $trackingStatuses[] = new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture());
    }
    $collection = new TrackingStatusCollection($trackingStatuses);
    $this->assertSame($trackingStatuses, $collection->all());
  }

  public function testKey(): void {
    $trackingStatuses = [
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
    ];
    $collection = new TrackingStatusCollection($trackingStatuses);
    $this->assertSame(0, $collection->key());
    $collection->next();
    $this->assertSame(1, $collection->key());
  }

  public function testRewind(): void {
    $trackingStatuses = [
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
    ];
    $collection = new TrackingStatusCollection($trackingStatuses);
    $collection->next();
    $this->assertSame(1, $collection->key());
    $collection->rewind();
    $this->assertSame(0, $collection->key());
  }

  public function testCurrent(): void {
    $trackingStatuses = [
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
    ];
    $collection = new TrackingStatusCollection($trackingStatuses);
    $this->assertSame($trackingStatuses[0], $collection->current());
    $collection->next();
    $this->assertSame($trackingStatuses[1], $collection->current());
  }

  public function testNext(): void {
    $trackingStatuses = [
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture()),
    ];
    $collection = new TrackingStatusCollection($trackingStatuses);
    $this->assertSame($trackingStatuses[0], $collection->current());
    $collection->next();
    $this->assertSame($trackingStatuses[1], $collection->current());
  }

  public function testValid(): void {
    $collection = new TrackingStatusCollection([
      new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture())
    ]);
    $this->assertTrue($collection->valid());
    $collection->next();
    $this->assertFalse($collection->valid());
  }

  /**
   * @covers \Ukrposhta\Tracking\TrackingStatusCollection::count
   */
  public function testCount(): void {
    $count = mt_rand(2, 10);
    $trackingStatuses = [];
    for ($i = 0; $i < $count; $i++) {
      $trackingStatuses[] = new TrackingStatus(...TrackingStatusHelper::getRandomTrackingStatusFixture());
    }
    $collection = new TrackingStatusCollection($trackingStatuses);
    $this->assertSame($count, $collection->count());
  }

}
