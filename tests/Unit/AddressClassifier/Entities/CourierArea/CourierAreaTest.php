<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\CourierArea;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierArea;

#[CoversClass(CourierArea::class)]
#[Small]
class CourierAreaTest extends TestCase
{

    public function testIsCourierArea(): void
    {
        // Test true condition.
        $courierAreaTrue = new CourierArea(true);
        $this->assertTrue($courierAreaTrue->isCourierArea());

        // Test false condition.
        $courierAreaFalse = new CourierArea(false);
        $this->assertFalse($courierAreaFalse->isCourierArea());
    }

    public function testFromResponseEntry(): void
    {
        // Test with IS_COURIERAREA set to true.
        $entryTrue = ['IS_COURIERAREA' => true];
        $courierAreaFromTrue = CourierArea::fromResponseEntry($entryTrue);
        $this->assertInstanceOf(CourierArea::class, $courierAreaFromTrue);
        $this->assertTrue($courierAreaFromTrue->isCourierArea());

        // Test with IS_COURIERAREA not set or false.
        $entryFalse = ['IS_COURIERAREA' => false];
        $courierAreaFromFalse = CourierArea::fromResponseEntry($entryFalse);
        $this->assertInstanceOf(CourierArea::class, $courierAreaFromFalse);
        $this->assertFalse($courierAreaFromFalse->isCourierArea());

        // Optionally, test with IS_COURIERAREA not present in the array.
        $entryNotSet = [];
        $courierAreaFromNotSet = CourierArea::fromResponseEntry($entryNotSet);
        $this->assertInstanceOf(CourierArea::class, $courierAreaFromNotSet);
        $this->assertFalse($courierAreaFromNotSet->isCourierArea());
    }

}
