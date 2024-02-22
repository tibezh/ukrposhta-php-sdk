<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\DistrictSearchItem;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\DistrictSearchItem\DistrictSearchItem;

#[CoversClass(DistrictSearchItem::class)]
#[Small]
class DistrictSearchItemTest extends TestCase
{

    private DistrictSearchItem $districtSearchItem;

    protected function setUp(): void
    {
        $this->districtSearchItem = new DistrictSearchItem(
            id: 1,
            name: 'District Name',
            regionId: 10,
            regionName: 'Region Name'
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->districtSearchItem->getId());
        $this->assertEquals('District Name', $this->districtSearchItem->getName());
        $this->assertEquals(10, $this->districtSearchItem->getRegionId());
        $this->assertEquals('Region Name', $this->districtSearchItem->getRegionName());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'District Name',
            'region_id' => 10,
            'region_name' => 'Region Name',
        ];

        $this->assertEquals($expected, $this->districtSearchItem->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'DISTRICT_ID' => '2',
            'DISTRICT_NAME' => 'Another District',
            'REGION_ID' => '20',
            'REGION_NAME' => 'Another Region',
        ];

        $districtSearchItem = DistrictSearchItem::fromResponseEntry($entry);

        $this->assertInstanceOf(DistrictSearchItem::class, $districtSearchItem);
        $this->assertEquals($entry['DISTRICT_ID'], $districtSearchItem->getId());
        $this->assertEquals($entry['DISTRICT_NAME'], $districtSearchItem->getName());
        $this->assertEquals($entry['REGION_ID'], $districtSearchItem->getRegionId());
        $this->assertEquals($entry['REGION_NAME'], $districtSearchItem->getRegionName());
    }

}
