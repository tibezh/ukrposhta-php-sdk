<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\Address;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\Address\Address;

#[CoversClass(Address::class)]
#[Small]
class AddressTest extends TestCase
{
    private Address $address;

    protected function setUp(): void
    {
        $this->address = new Address(
            regionId: 1,
            regionName: 'RegionName',
            districtId: 2,
            districtName: 'DistrictName',
            cityId: 3,
            cityName: 'CityName',
            cityTypeId: 4,
            cityTypeName: 'CityTypeName',
            streetId: 5,
            streetName: 'StreetName',
            streetTypeId: 6,
            streetTypeName: 'StreetTypeName',
            streetShorTypeName: 'StreetShortTypeName',
            postCode: 123456,
            houseNumber: '123A'
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->address->getRegionId());
        $this->assertEquals('RegionName', $this->address->getRegionName());
        $this->assertEquals(2, $this->address->getDistrictId());
        $this->assertEquals(3, $this->address->getCityId());
        $this->assertEquals('CityName', $this->address->getCityName());
        $this->assertEquals('CityTypeName', $this->address->getCityTypeName());
        $this->assertEquals(5, $this->address->getStreetId());
        $this->assertEquals('StreetName', $this->address->getStreetName());
        $this->assertEquals(6, $this->address->getStreetTypeId());
        $this->assertEquals('StreetTypeName', $this->address->getStreetTypeName());
        $this->assertEquals('StreetShortTypeName', $this->address->getStreetShortTypeName());
        $this->assertEquals(123456, $this->address->getPostCode());
        $this->assertEquals('123A', $this->address->getHouseNumber());
    }

    public function testToArray(): void
    {
        $expected = [
            'region_id' => 1,
            'region_name' => 'RegionName',
            'district_id' => 2,
            'district_name' => 'DistrictName',
            'city_id' => 3,
            'city_name' => 'CityName',
            'city_type_id' => 4,
            'city_type_name' => 'CityTypeName',
            'street_id' => 5,
            'street_name' => 'StreetName',
            'street_type_id' => 6,
            'street_type_name' => 'StreetTypeName',
            'street_short_type_name' => 'StreetShortTypeName',
            'postcode' => 123456,
            'house_number' => '123A',
        ];

        $this->assertEquals($expected, $this->address->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'REGION_ID' => '1',
            'REGION_NAME' => 'RegionName',
            'DISTRICT_ID' => 2,
            'DISTRICT_NAME' => 'DistrictName',
            'CITY_ID' => 3,
            'CITY_NAME' => 'CityName',
            'CTIYTYPE_ID' => 5,
            'CITYTYPE_NAME' => 'CityTypeName',
            'STREET_ID' => 5,
            'STREET_NAME' => 'StreetName',
            'STREETTYPE_ID' => 6,
            'STREETTYPE_NAME' => 'StreetTypeName',
            'SHORTSTREETTYPE_NAME' => 'StreetShortTypeName',
            'POSTCODE' => '123456',
            'HOUSENUMBER' => '123A',
        ];

        $addressFromResponse = Address::fromResponseEntry($entry);

        $this->assertInstanceOf(Address::class, $addressFromResponse);
        $this->assertEquals($entry['REGION_ID'], $addressFromResponse->getRegionId());
        $this->assertEquals($entry['REGION_NAME'], $addressFromResponse->getRegionName());
        $this->assertEquals($entry['DISTRICT_ID'], $addressFromResponse->getDistrictId());
        $this->assertEquals($entry['DISTRICT_NAME'], $addressFromResponse->getDistrictName());
        $this->assertEquals($entry['CITY_ID'], $addressFromResponse->getCityId());
        $this->assertEquals($entry['CITY_NAME'], $addressFromResponse->getCityName());
        $this->assertEquals($entry['CTIYTYPE_ID'], $addressFromResponse->getCityTypeId());
        $this->assertEquals($entry['CITYTYPE_NAME'], $addressFromResponse->getCityTypeName());
        $this->assertEquals($entry['STREET_ID'], $addressFromResponse->getStreetId());
        $this->assertEquals($entry['STREET_NAME'], $addressFromResponse->getStreetName());
        $this->assertEquals($entry['STREETTYPE_ID'], $addressFromResponse->getStreetTypeId());
        $this->assertEquals($entry['STREETTYPE_NAME'], $addressFromResponse->getStreetTypeName());
        $this->assertEquals($entry['SHORTSTREETTYPE_NAME'], $addressFromResponse->getStreetShortTypeName());
        $this->assertEquals($entry['POSTCODE'], $addressFromResponse->getPostCode());
        $this->assertEquals($entry['HOUSENUMBER'], $addressFromResponse->getHouseNumber());
    }

}
