<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\Settlement;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\Settlement\Settlement;

#[CoversClass(Settlement::class)]
#[Small]
class SettlementTest extends TestCase
{
    private Settlement $settlement;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->settlement = new Settlement(
            postCode: 12345,
            regionId: 1,
            regionName: 'Test Region',
            districtId: 2,
            districtName: 'Test District',
            cityId: 3,
            cityName: 'Test City',
            cityTypeName: 'Test City Type'
        );
    }

    public function testGetPostCode(): void
    {
        $this->assertEquals(12345, $this->settlement->getPostCode());
    }

    public function testGetRegionId(): void
    {
        $this->assertEquals(1, $this->settlement->getRegionId());
    }

    public function testGetRegionName(): void
    {
        $this->assertEquals('Test Region', $this->settlement->getRegionName());
    }

    public function testGetDistrictId(): void
    {
        $this->assertEquals(2, $this->settlement->getDistrictId());
    }

    public function testGetDistrictName(): void
    {
        $this->assertEquals('Test District', $this->settlement->getDistrictName());
    }

    public function testGetCityId(): void
    {
        $this->assertEquals(3, $this->settlement->getCityId());
    }

    public function testGetCityName(): void
    {
        $this->assertEquals('Test City', $this->settlement->getCityName());
    }

    public function testGetCityTypeName(): void
    {
        $this->assertEquals('Test City Type', $this->settlement->getCityTypeName());
    }

    public function testToArray(): void
    {
        $expected = [
            'postcode' => 12345,
            'region_id' => 1,
            'region_name' => 'Test Region',
            'district_id' => 2,
            'district_name' => 'Test District',
            'city_id' => 3,
            'city_name' => 'Test City',
            'city_type_name' => 'Test City Type',
        ];

        $this->assertEquals($expected, $this->settlement->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'POSTCODE' => '67890',
            'REGION_ID' => '4',
            'REGION_NAME' => 'Another Region',
            'DISTRICT_ID' => '5',
            'DISTRICT_NAME' => 'Another District',
            'CITY_ID' => '6',
            'CITY_NAME' => 'Another City',
            'CITYTYPE_NAME' => 'Another City Type'
        ];

        $settlementFromResponse = Settlement::fromResponseEntry($entry);

        $this->assertInstanceOf(Settlement::class, $settlementFromResponse);
        $this->assertEquals(67890, $settlementFromResponse->getPostCode());
        $this->assertEquals(4, $settlementFromResponse->getRegionId());
        $this->assertEquals('Another Region', $settlementFromResponse->getRegionName());
        $this->assertEquals(5, $settlementFromResponse->getDistrictId());
        $this->assertEquals('Another District', $settlementFromResponse->getDistrictName());
        $this->assertEquals(6, $settlementFromResponse->getCityId());
        $this->assertEquals('Another City', $settlementFromResponse->getCityName());
        $this->assertEquals('Another City Type', $settlementFromResponse->getCityTypeName());
    }

}
