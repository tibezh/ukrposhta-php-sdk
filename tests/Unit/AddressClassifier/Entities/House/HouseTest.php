<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\House;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\House\House;

#[CoversClass(House::class)]
#[Small]
class HouseTest extends TestCase
{

    private House $house;

    protected function setUp(): void
    {
        $this->house = new House(
            postCode: 12345,
            houseNumber: '67B'
        );
    }

    public function testGetPostCode(): void
    {
        $this->assertEquals(12345, $this->house->getPostCode());
    }

    public function testGetHouseNumber(): void
    {
        $this->assertEquals('67B', $this->house->getHouseNumber());
    }

    public function testToArray(): void
    {
        $expected = [
            'postcode' => 12345,
            'house_number' => '67B',
        ];

        $this->assertEquals($expected, $this->house->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'POSTCODE' => '89012',
            'HOUSENUMBER_UA' => '12A'
        ];

        $house = House::fromResponseEntry($entry);

        $this->assertInstanceOf(House::class, $house);
        $this->assertEquals(89012, $house->getPostCode());
        $this->assertEquals('12A', $house->getHouseNumber());
    }

}
