<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Tracking\Entities\TrackingRoute;
use Ukrposhta\Tracking\Entities\TrackingRouteInterface;

#[CoversClass(TrackingRoute::class)]
#[CoversClass(TrackingRouteInterface::class)]
#[Small]
final class TrackingRouteTest extends TestCase
{

    public function testInterface(): void
    {
        $trackingRoute = new TrackingRoute(
            from: 'Ukraine interface from',
            to: 'Ukraine interface to'
        );
        $this->assertInstanceOf(TrackingRouteInterface::class, $trackingRoute);
    }

    public function testGetFrom(): void
    {
        $from = 'Ukraine get from';
        $to = 'Ukraine get from to';
        $trackingRoute = new TrackingRoute(from: $from, to: $to);
        $this->assertSame($from, $trackingRoute->getFrom());
        $this->assertSame($to, $trackingRoute->getTo());
    }

    /**
     * @covers \Ukrposhta\Tracking\Entities\TrackingRoute::getFrom
     * @covers \Ukrposhta\Tracking\Entities\TrackingRoute::getTo
     */
    public function testCanBeCreatedWithValidData(): void
    {
        $from = 'Ukraine valid data from';
        $to = 'Ukraine valid data to';
        $trackingRoute = new TrackingRoute(from: $from, to: $to);
        $this->assertSame($from, $trackingRoute->getFrom());
        $this->assertSame($to, $trackingRoute->getTo());
    }

    public function testCannotBeCreatedWithNotValidArgumentData1(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute();
    }

    public function testCannotBeCreatedWithNotValidArgumentData2(): void
    {
        $this->expectException(\ArgumentCountError::class);
        $from = 'Ukraine with not valid argument data 2';
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: $from);
    }

    public function testCannotBeCreatedWithNotValidArgumentData3(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: 'Ukraine with not valid argument data 3');
    }

    public function testCannotBeCreatedWithNotValidTypeData1(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: 0123, to: 'Ukraine');
    }

    public function testCannotBeCreatedWithNotValidTypeData2(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: 'Ukraine', to: 2143);
    }
}
