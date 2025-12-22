<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\StreetSearchItem;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\StreetSearchItem\StreetSearchItem;

#[CoversClass(StreetSearchItem::class)]
#[Small]
class StreetSearchItemTest extends TestCase
{

    private StreetSearchItem $streetSearchItem;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->streetSearchItem = new StreetSearchItem(
            id: 1,
            name: 'Liberty Avenue',
            typeId: 2,
            typeName: 'Avenue',
            shortTypeName: 'Ave',
            regionId: 3,
            regionName: 'Freedom Region',
            districtId: 4,
            districtName: 'Liberty District',
            cityId: 5,
            cityName: 'Liberty City',
            cityTypeId: 6,
            cityTypeName: 'City'
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->streetSearchItem->getId());
    }

    public function testGetName(): void
    {
        $this->assertEquals('Liberty Avenue', $this->streetSearchItem->getName());
    }

    public function testGetTypeId(): void
    {
        $this->assertEquals(2, $this->streetSearchItem->getTypeId());
    }

    public function testGetTypeName(): void
    {
        $this->assertEquals('Avenue', $this->streetSearchItem->getTypeName());
    }

    public function testGetShortTypeName(): void
    {
        $this->assertEquals('Ave', $this->streetSearchItem->getShortTypeName());
    }

    public function testGetRegionId(): void
    {
        $this->assertEquals(3, $this->streetSearchItem->getRegionId());
    }

    public function testGetRegionName(): void
    {
        $this->assertEquals('Freedom Region', $this->streetSearchItem->getRegionName());
    }

    public function testGetDistrictId(): void
    {
        $this->assertEquals(4, $this->streetSearchItem->getDistrictId());
    }

    public function testGetDistrictName(): void
    {
        $this->assertEquals('Liberty District', $this->streetSearchItem->getDistrictName());
    }

    public function testGetCityId(): void
    {
        $this->assertEquals(5, $this->streetSearchItem->getCityId());
    }

    public function testGetCityName(): void
    {
        $this->assertEquals('Liberty City', $this->streetSearchItem->getCityName());
    }

    public function testGetCityTypeId(): void
    {
        $this->assertEquals(6, $this->streetSearchItem->getCityTypeId());
    }

    public function testGetCityTypeName(): void
    {
        $this->assertEquals('City', $this->streetSearchItem->getCityTypeName());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Liberty Avenue',
            'type_id' => 2,
            'type_name' => 'Avenue',
            'short_type_name' => 'Ave',
            'region_id' => 3,
            'region_name' => 'Freedom Region',
            'district_id' => 4,
            'district_name' => 'Liberty District',
            'city_id' => 5,
            'city_name' => 'Liberty City',
            'city_type_id' => 6,
            'city_type_name' => 'City',
        ];

        $this->assertEquals($expected, $this->streetSearchItem->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'STREET_ID' => '10',
            'STREET_NAME' => 'Independence Road',
            'STREETTYPE_ID' => '3',
            'STREETTYPE_NAME' => 'Road',
            'SHORTSTREETTYPE_NAME' => 'Rd',
            'REGION_ID' => '4',
            'REGION_NAME' => 'Independence Region',
            'DISTRICT_ID' => '5',
            'DISTRICT_NAME' => 'Freedom District',
            'CITY_ID' => '6',
            'CITY_NAME' => 'Freedom City',
            'CITYTYPE_ID' => '7',
            'CITYTYPE_NAME' => 'Metropolis',
        ];

        $streetSearchItem = StreetSearchItem::fromResponseEntry($entry);

        $this->assertInstanceOf(StreetSearchItem::class, $streetSearchItem);
        $this->assertEquals(10, $streetSearchItem->getId());
        $this->assertEquals('Independence Road', $streetSearchItem->getName());
        $this->assertEquals(3, $streetSearchItem->getTypeId());
        $this->assertEquals('Road', $streetSearchItem->getTypeName());
        $this->assertEquals('Rd', $streetSearchItem->getShortTypeName());
        $this->assertEquals(4, $streetSearchItem->getRegionId());
        $this->assertEquals('Independence Region', $streetSearchItem->getRegionName());
        $this->assertEquals(5, $streetSearchItem->getDistrictId());
        $this->assertEquals('Freedom District', $streetSearchItem->getDistrictName());
        $this->assertEquals(6, $streetSearchItem->getCityId());
        $this->assertEquals('Freedom City', $streetSearchItem->getCityName());
        $this->assertEquals(7, $streetSearchItem->getCityTypeId());
        $this->assertEquals('Metropolis', $streetSearchItem->getCityTypeName());
    }

}
