<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\PostOffice;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOffice;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(PostOffice::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Medium]
class PostOfficeTest extends TestCase
{

    private PostOffice $postOffice;
    private object $lockMock;
    private object $serviceAreaCityMock;
    private object $serviceAreaCityTypeMock;
    private object $serviceAreaShortCityTypeMock;

    protected function setUp(): void
    {
        $this->lockMock = $this->createMock(StringMultilingualInterface::class);
        $this->lockMock->method('getByLangOrArray')->willReturn('Lock Name');

        $this->serviceAreaCityMock = $this->createMock(StringMultilingualInterface::class);
        $this->serviceAreaCityMock->method('getByLangOrArray')->willReturn('Service Area City');

        $this->serviceAreaCityTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->serviceAreaCityTypeMock->method('getByLangOrArray')->willReturn('Service Area City Type');

        $this->serviceAreaShortCityTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->serviceAreaShortCityTypeMock->method('getByLangOrArray')->willReturn('Service Area Short City Type');

        $this->postOffice = new PostOffice(
            id: 1,
            code: 100,
            name: 'Main Post Office',
            shortName: 'MPO',
            type: 'Type1',
            typeShort: 'T1',
            typeAcronym: 'TA',
            postIndex: 12345,
            postCode: 54321,
            merezaNumber: 111,
            lock: $this->lockMock,
            lockCode: 222,
            regionId: 2,
            serviceAreaRegionId: 3,
            districtId: 4,
            serviceAreaDistrictId: 5,
            cityId: 6,
            cityType: 'CityType',
            serviceAreaCityId: 7,
            serviceAreaCity: $this->serviceAreaCityMock,
            serviceAreaCityType: $this->serviceAreaCityTypeMock,
            serviceAreaShortCityType: $this->serviceAreaShortCityTypeMock,
            streetId: 8,
            parentId: 9,
            address: '123 Main St',
            phone: '123-456-7890',
            longitude: 10.123,
            latitude: -11.456,
            isVpz: true,
            isAvailable: false,
            mrtps: 333,
            techIndex: 444,
            isDeliveryPossible: true
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->postOffice->getId());
        $this->assertEquals(100, $this->postOffice->getCode());
        $this->assertEquals('Main Post Office', $this->postOffice->getName());
        $this->assertEquals('MPO', $this->postOffice->getShortName());
        $this->assertEquals('Type1', $this->postOffice->getType());
        $this->assertEquals('T1', $this->postOffice->getShortType());
        $this->assertEquals('TA', $this->postOffice->getTypeAcronymName());
        $this->assertEquals(12345, $this->postOffice->getPostIndex());
        $this->assertEquals(54321, $this->postOffice->getPostCode());
        $this->assertEquals(111, $this->postOffice->getMerezaNumber());
        $this->assertEquals($this->lockMock, $this->postOffice->getLock());
        $this->assertEquals(222, $this->postOffice->getLockCode());
        $this->assertEquals(2, $this->postOffice->getRegionId());
        $this->assertEquals(3, $this->postOffice->getServiceAreaRegionId());
        $this->assertEquals(4, $this->postOffice->getDistrictId());
        $this->assertEquals(5, $this->postOffice->getServiceAreaDistrictId());
        $this->assertEquals(6, $this->postOffice->getCityId());
        $this->assertEquals('CityType', $this->postOffice->getCityType());
        $this->assertEquals(7, $this->postOffice->getServiceAreaCityId());
        $this->assertEquals($this->serviceAreaCityMock, $this->postOffice->getServiceAreaCity());
        $this->assertEquals($this->serviceAreaCityTypeMock, $this->postOffice->getServiceAreaCityType());
        $this->assertEquals($this->serviceAreaShortCityTypeMock, $this->postOffice->getServiceAreaShortCityType());
        $this->assertEquals(8, $this->postOffice->getStreetId());
        $this->assertEquals(9, $this->postOffice->getParentId());
        $this->assertEquals('123 Main St', $this->postOffice->getAddress());
        $this->assertEquals('123-456-7890', $this->postOffice->getPhoneNumber());
        $this->assertEquals(10.123, $this->postOffice->getLongitude());
        $this->assertEquals(-11.456, $this->postOffice->getLatitude());
        $this->assertTrue($this->postOffice->isVpz());
        $this->assertFalse($this->postOffice->isAvailable());
        $this->assertEquals(333, $this->postOffice->getmrtps());
        $this->assertEquals(444, $this->postOffice->gettechIndex());
        $this->assertTrue($this->postOffice->isDeliveryPossible());
    }

    public function testToArray(): void
    {

        $expectedArray = [
            'id' => 1,
            'code' => 100,
            'name' => 'Main Post Office',
            'short_name' => 'MPO',
            'type' => 'Type1',
            'short_type' => 'T1',
            'type_acronym' => 'TA',
            'post_index' => 12345,
            'postcode' => 54321,
            'mereza_number' => 111,
            'lock' => 'Lock Name',
            'lock_code' => 222,
            'region_id' => 2,
            'service_area_region_id' => 3,
            'district_id' => 4,
            'service_area_district_id' => 5,
            'city_id' => 6,
            'city_type' => 'CityType',
            'service_area_city_id' => 7,
            'service_area_city' => 'Service Area City',
            'service_area_city_type' => 'Service Area City Type',
            'service_area_short_city_type' => 'Service Area Short City Type',
            'street_id' => 8,
            'parent_id' => 9,
            'address' => '123 Main St',
            'phone' => '123-456-7890',
            'longitude' => 10.123,
            'latitude' => -11.456,
            'is_vpz' => true,
            'is_available' => false,
            'mrtps' => 333,
            'tech_index' => 444,
            'is_delivery_possible' => true
        ];

        $this->assertEquals($expectedArray, $this->postOffice->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'ID' => '10',
            'PO_CODE' => '200',
            'PO_LONG' => 'Main Post Office',
            'PO_SHORT' => 'MPO',
            'TYPE_LONG' => 'Type1',
            'TYPE_SHORT' => 'T1',
            'TYPE_ACRONYM' => 'TA',
            'POSTINDEX' => '12345',
            'POSTCODE' => '54321',
            'MEREZA_NUMBER' => '111',
            'POLOCK_UA' => 'Lock Name Ua',
            'POLOCK_EN' => 'Lock Name En',
            'LOCK_CODE' => '222',
            'POREGION_ID' => '2',
            'PDREGION_ID' => '3',
            'PODISTRICT_ID' => '4',
            'PDDISTRICT_ID' => '5',
            'POCITY_ID' => '6',
            'CITYTYPE_UA' => 'CityType',
            'PDCITY_ID' => '7',
            'PDCITY_UA' => 'ServiceAreaCity Ua',
            'PDCITY_EN' => 'ServiceAreaCity En',
            'PDCITYTYPE_UA' => 'ServiceAreaCityType Ua',
            'PDCITYTYPE_EN' => 'ServiceAreaCityType En',
            'SHORTPDCITYTYPE_UA' => 'serviceAreaShortCityType Ua',
            'SHORTPDCITYTYPE_EN' => 'serviceAreaShortCityType En',
            'POSTREET_ID' => '8',
            'PARENT_ID' => '9',
            'ADDRESS' => '123 Main St',
            'PHONE' => '123-456-7890',
            'LONGITUDE' => '10.123',
            'LATTITUDE' => '-11.456',
            'ISVPZ' => '1',
            'AVALIBLE' => '0',
            'MRTPS' => '333',
            'TECHINDEX' => '444',
            'IS_NODISTRICT' => '0',
        ];

        $postOffice = PostOffice::fromResponseEntry($entry);

        $this->assertInstanceOf(PostOffice::class, $postOffice);
        $this->assertEquals(10, $postOffice->getId());
        $this->assertEquals(200, $postOffice->getCode());
        $this->assertEquals('Main Post Office', $postOffice->getName());
        $this->assertEquals('MPO', $postOffice->getShortName());
        $this->assertEquals('Type1', $postOffice->getType());
        $this->assertEquals('T1', $postOffice->getShortType());
        $this->assertEquals('TA', $postOffice->getTypeAcronymName());
        $this->assertEquals(12345, $postOffice->getPostIndex());
        $this->assertEquals(54321, $postOffice->getPostCode());
        $this->assertEquals(111, $postOffice->getMerezaNumber());
        $this->assertEquals(
            ['ua' => 'Lock Name Ua', 'en' => 'Lock Name En'],
            $postOffice->getLock()->getByLangOrArray()
        );
        $this->assertEquals(222, $postOffice->getLockCode());
        $this->assertEquals(2, $postOffice->getRegionId());
        $this->assertEquals(3, $postOffice->getServiceAreaRegionId());
        $this->assertEquals(4, $postOffice->getDistrictId());
        $this->assertEquals(5, $postOffice->getServiceAreaDistrictId());
        $this->assertEquals(6, $postOffice->getCityId());
        $this->assertEquals('CityType', $postOffice->getCityType());
        $this->assertEquals(7, $postOffice->getServiceAreaCityId());
        $this->assertEquals(
            ['ua' => 'ServiceAreaCity Ua', 'en' => 'ServiceAreaCity En'],
            $postOffice->getServiceAreaCity()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'ServiceAreaCityType Ua', 'en' => 'ServiceAreaCityType En'],
            $postOffice->getServiceAreaCityType()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'serviceAreaShortCityType Ua', 'en' => 'serviceAreaShortCityType En'],
            $postOffice->getServiceAreaShortCityType()->getByLangOrArray()
        );
        $this->assertEquals(8, $postOffice->getStreetId());
        $this->assertEquals(9, $postOffice->getParentId());
        $this->assertEquals('123 Main St', $postOffice->getAddress());
        $this->assertEquals('123-456-7890', $postOffice->getPhoneNumber());
        $this->assertEquals(10.123, $postOffice->getLongitude());
        $this->assertEquals(-11.456, $postOffice->getLatitude());
        $this->assertTrue($postOffice->isVpz());
        $this->assertFalse($postOffice->isAvailable());
        $this->assertEquals(333, $postOffice->getmrtps());
        $this->assertEquals(444, $postOffice->gettechIndex());
        $this->assertTrue($postOffice->isDeliveryPossible());
    }

}
