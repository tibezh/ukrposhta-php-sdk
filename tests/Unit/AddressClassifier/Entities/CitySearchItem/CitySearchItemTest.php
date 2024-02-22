<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\CitySearchItem;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\CitySearchItem\CitySearchItem;

#[CoversClass(CitySearchItem::class)]
#[Small]
class CitySearchItemTest extends TestCase
{

    private CitySearchItem $citySearchItem;

    protected function setUp(): void
    {
        $this->citySearchItem = new CitySearchItem(
            id: 1,
            name: 'CityName',
            typeId: 2,
            typeName: 'CityTypeName',
            regionId: 3,
            regionName: 'RegionName',
            districtId: 4,
            districtName: 'DistrictName'
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->citySearchItem->getId());
        $this->assertEquals('CityName', $this->citySearchItem->getName());
        $this->assertEquals(2, $this->citySearchItem->getTypeId());
        $this->assertEquals('CityTypeName', $this->citySearchItem->getTypeName());
        $this->assertEquals(3, $this->citySearchItem->getRegionId());
        $this->assertEquals('RegionName', $this->citySearchItem->getRegionName());
        $this->assertEquals(4, $this->citySearchItem->getDistrictId());
        $this->assertEquals('DistrictName', $this->citySearchItem->getDistrictName());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'CityName',
            'type_id' => 2,
            'type_name' => 'CityTypeName',
            'region_id' => 3,
            'region_name' => 'RegionName',
            'district_id' => 4,
            'district_name' => 'DistrictName',
        ];

        $this->assertEquals($expected, $this->citySearchItem->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'CITY_ID' => '1',
            'CITY_NAME' => 'CityName',
            'CITYTYPE_ID' => '2',
            'CITYTYPE_NAME' => 'CityTypeName',
            'REGION_ID' => '3',
            'REGION_NAME' => 'RegionName',
            'DISTRICT_ID' => '4',
            'DISTRICT_NAME' => 'DistrictName',
        ];

        $citySearchItem = CitySearchItem::fromResponseEntry($entry);

        $this->assertInstanceOf(CitySearchItem::class, $citySearchItem);
        $this->assertEquals($entry['CITY_ID'], $citySearchItem->getId());
        $this->assertEquals($entry['CITY_NAME'], $citySearchItem->getName());
        $this->assertEquals($entry['CITYTYPE_ID'], $citySearchItem->getTypeId());
        $this->assertEquals($entry['CITYTYPE_NAME'], $citySearchItem->getTypeName());
        $this->assertEquals($entry['REGION_ID'], $citySearchItem->getRegionId());
        $this->assertEquals($entry['REGION_NAME'], $citySearchItem->getRegionName());
        $this->assertEquals($entry['DISTRICT_ID'], $citySearchItem->getDistrictId());
        $this->assertEquals($entry['DISTRICT_NAME'], $citySearchItem->getDistrictName());
    }

}
