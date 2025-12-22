<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\DeliveryArea;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\DeliveryArea\DeliveryArea;

#[CoversClass(DeliveryArea::class)]
#[Small]
class DeliveryAreaTest extends TestCase
{

    private DeliveryArea $deliveryArea;

    protected function setUp(): void
    {
        $this->deliveryArea = new DeliveryArea(cityId: 123, postCode: 45678);
    }

    public function testGetters(): void
    {
        $this->assertEquals(123, $this->deliveryArea->getCityId());
        $this->assertEquals(45678, $this->deliveryArea->getPostCode());
    }

    public function testToArray(): void
    {
        $expected = [
            'city_id' => 123,
            'postcode' => 45678,
        ];

        $this->assertEquals($expected, $this->deliveryArea->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'CITY_ID' => '123',
            'POSTCODE' => '45678',
        ];

        $deliveryArea = DeliveryArea::fromResponseEntry($entry);

        $this->assertInstanceOf(DeliveryArea::class, $deliveryArea);
        $this->assertEquals($entry['CITY_ID'], $deliveryArea->getCityId());
        $this->assertEquals($entry['POSTCODE'], $deliveryArea->getPostCode());
    }

}
