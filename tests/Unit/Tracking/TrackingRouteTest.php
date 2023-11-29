<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Tests\Utils\FakerGeneratorTrait;
use Ukrposhta\Tracking\TrackingRoute;
use Ukrposhta\Tracking\TrackingRouteInterface;

#[CoversClass(TrackingRoute::class)]
#[CoversClass(TrackingRouteInterface::class)]
#[Small]
final class TrackingRouteTest extends TestCase
{
    use FakerGeneratorTrait;

    public function testInterface(): void
    {
        $trackingRoute = new TrackingRoute(
            from: $this->fakerGenerator()->address(),
            to: $this->fakerGenerator()->address()
        );
        $this->assertInstanceOf(TrackingRouteInterface::class, $trackingRoute);
    }

    public function testGetFrom(): void
    {
        $from = $this->fakerGenerator()->address();
        $to = $this->fakerGenerator()->address();
        $trackingRoute = new TrackingRoute(from: $from, to: $to);
        $this->assertSame($from, $trackingRoute->getFrom());
        $this->assertSame($to, $trackingRoute->getTo());
    }

    /**
     * @covers \Ukrposhta\Tracking\TrackingRoute::getFrom
     * @covers \Ukrposhta\Tracking\TrackingRoute::getTo
     */
    public function testCanBeCreatedWithValidData(): void
    {
        $from = $this->fakerGenerator()->address();
        $to = $this->fakerGenerator()->address();
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
        $from = $this->fakerGenerator()->address();
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: $from);
    }

    public function testCannotBeCreatedWithNotValidArgumentData3(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: $this->fakerGenerator()->address());
    }

    public function testCannotBeCreatedWithNotValidTypeData1(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: $this->fakerGenerator()->randomDigit(), to: $this->fakerGenerator()->address());
    }

    public function testCannotBeCreatedWithNotValidTypeData2(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new TrackingRoute(from: $this->fakerGenerator()->address(), to: $this->fakerGenerator()->randomDigit());
    }
}
