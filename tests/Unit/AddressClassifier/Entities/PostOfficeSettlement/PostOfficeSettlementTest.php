<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\PostOfficeSettlement;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlement;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(PostOfficeSettlement::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Medium]
class PostOfficeSettlementTest extends TestCase
{

    private PostOfficeSettlement $postOfficeSettlement;

    private object $cityMock;
    private object $cityTypeMock;
    private object $shortCityTypeMock;
    private object $regionMock;
    private object $districtMock;
    private object $streetMock;
    private object $streetTypeMock;
    private object $lockMock;

    protected function setUp(): void
    {
        $this->cityMock = $this->createMock(StringMultilingualInterface::class);
        $this->cityMock->method('getByLangOrArray')->willReturn('City');

        $this->cityTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->cityTypeMock->method('getByLangOrArray')->willReturn('CityType');

        $this->shortCityTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->shortCityTypeMock->method('getByLangOrArray')->willReturn('ShortCityType');

        $this->regionMock = $this->createMock(StringMultilingualInterface::class);
        $this->regionMock->method('getByLangOrArray')->willReturn('Region');

        $this->districtMock = $this->createMock(StringMultilingualInterface::class);
        $this->districtMock->method('getByLangOrArray')->willReturn('District');

        $this->streetMock = $this->createMock(StringMultilingualInterface::class);
        $this->streetMock->method('getByLangOrArray')->willReturn('Street');

        $this->streetTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->streetTypeMock->method('getByLangOrArray')->willReturn('StreetType');

        $this->lockMock = $this->createMock(StringMultilingualInterface::class);
        $this->lockMock->method('getByLangOrArray')->willReturn('Lock');

        $this->postOfficeSettlement = new PostOfficeSettlement(
            id: 1,
            name: 'Main Office',
            shortName: 'MO',
            type: 'Office Type',
            shortType: 'OT',
            typeAcronym: 'OTA',
            parentId: 2,
            cityId: 3,
            city: $this->cityMock,
            cityType: $this->cityTypeMock,
            shortCityType: $this->shortCityTypeMock,
            postIndex: 123456,
            regionId: 4,
            region: $this->regionMock,
            districtId: 5,
            district: $this->districtMock,
            street: $this->streetMock,
            streetType: $this->streetTypeMock,
            houseNumber: '6A',
            address: '123 Main Street',
            longitude: 50.123456,
            latitude: 30.654321,
            isCash: true,
            isDhl: false,
            isSmartbox: true,
            isUrgentPostalTransfers: false,
            isFlagman: true,
            hasPostTerminal: false,
            isAutomated: true,
            isSecurity: false,
            lockCode: 789,
            lock: $this->lockMock,
            phone: '123-456-7890',
            isVpz: true,
            merezaNumber: 111,
            techIndex: 222
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->postOfficeSettlement->getId());
        $this->assertEquals('Main Office', $this->postOfficeSettlement->getName());
        $this->assertEquals('MO', $this->postOfficeSettlement->getShortName());
        $this->assertEquals('Office Type', $this->postOfficeSettlement->getType());
        $this->assertEquals('OT', $this->postOfficeSettlement->getShortType());
        $this->assertEquals('OTA', $this->postOfficeSettlement->getTypeAcronym());
        $this->assertEquals(2, $this->postOfficeSettlement->getParentId());
        $this->assertEquals(3, $this->postOfficeSettlement->getCityId());
        $this->assertEquals($this->cityMock, $this->postOfficeSettlement->getCity());
        $this->assertEquals($this->cityTypeMock, $this->postOfficeSettlement->getCityType());
        $this->assertEquals($this->shortCityTypeMock, $this->postOfficeSettlement->getShortCityType());
        $this->assertEquals(123456, $this->postOfficeSettlement->getPostIndex());
        $this->assertEquals(4, $this->postOfficeSettlement->getRegionId());
        $this->assertEquals($this->regionMock, $this->postOfficeSettlement->getRegion());
        $this->assertEquals(5, $this->postOfficeSettlement->getDistrictId());
        $this->assertEquals($this->districtMock, $this->postOfficeSettlement->getDistrict());
        $this->assertEquals($this->streetMock, $this->postOfficeSettlement->getStreet());
        $this->assertEquals($this->streetTypeMock, $this->postOfficeSettlement->getStreetType());
        $this->assertEquals('6A', $this->postOfficeSettlement->getHouseNumber());
        $this->assertEquals('123 Main Street', $this->postOfficeSettlement->getAddress());
        $this->assertEquals(50.123456, $this->postOfficeSettlement->getLongitude());
        $this->assertEquals(30.654321, $this->postOfficeSettlement->getLatitude());
        $this->assertTrue($this->postOfficeSettlement->isCash());
        $this->assertFalse($this->postOfficeSettlement->isDhl());
        $this->assertTrue($this->postOfficeSettlement->isSmartbox());
        $this->assertFalse($this->postOfficeSettlement->isUrgentPostalTransfers());
        $this->assertTrue($this->postOfficeSettlement->isFlagman());
        $this->assertFalse($this->postOfficeSettlement->hasPostTerminal());
        $this->assertTrue($this->postOfficeSettlement->isAutomated());
        $this->assertFalse($this->postOfficeSettlement->isSecurity());
        $this->assertEquals(789, $this->postOfficeSettlement->getLockCode());
        $this->assertEquals($this->lockMock, $this->postOfficeSettlement->getLock());
        $this->assertEquals('123-456-7890', $this->postOfficeSettlement->getPhone());
        $this->assertTrue($this->postOfficeSettlement->isVpz());
        $this->assertEquals(111, $this->postOfficeSettlement->getMerezaNumber());
        $this->assertEquals(222, $this->postOfficeSettlement->getTechIndex());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Main Office',
            'short_name' => 'MO',
            'type' => 'Office Type',
            'short_type' => 'OT',
            'type_acronym' => 'OTA',
            'parent_id' => 2,
            'city_id' => 3,
            'city' => 'City',
            'city_type' => 'CityType',
            'short_city_type' => 'ShortCityType',
            'post_index' => 123456,
            'region_id' => 4,
            'region' => 'Region',
            'district_id' => 5,
            'district' => 'District',
            'street' => 'Street',
            'street_type' => 'StreetType',
            'house_number' => '6A',
            'address' => '123 Main Street',
            'longitude' => 50.123456,
            'latitude' => 30.654321,
            'is_cash' => true,
            'is_dhl' => false,
            'is_smartbox' => true,
            'is_urgent_postal_transfers' => false,
            'is_flagman' => true,
            'has_post_terminal' => false,
            'is_automated' => true,
            'is_security' => false,
            'lock_code' => 789,
            'lock' => 'Lock',
            'phone' => '123-456-7890',
            'isVpz' => true,
            'mereza_number' => 111,
            'tech_index' => 222,
        ];
        $this->assertEquals($expected, $this->postOfficeSettlement->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'ID' => '1',
            'PO_LONG' => 'Main Office',
            'PO_SHORT' => 'MO',
            'TYPE_LONG' => 'Office Type',
            'TYPE_SHORT' => 'OT',
            'TYPE_ACRONYM' => 'OTA',
            'PARENT_ID' => '2',
            'CITY_ID' => '3',
            'CITY_UA' => 'CityName UA',
            'CITY_EN' => 'CityName EN',
            'CITYTYPE_UA' => 'CityType UA',
            'CITYTYPE_EN' => 'CityType EN',
            'SHORTCITYTYPE_UA' => 'ShortCityType UA',
            'SHORTCITYTYPE_EN' => 'ShortCityType EN',
            'POSTINDEX' => '123456',
            'REGION_ID' => '4',
            'REGION_UA' => 'RegionName UA',
            'REGION_EN' => 'RegionName EN',
            'DISTRICT_ID' => '5',
            'DISTRICT_UA' => 'DistrictName UA',
            'DISTRICT_EN' => 'DistrictName EN',
            'STREET_UA' => 'StreetName UA',
            'STREET_EN' => 'StreetName EN',
            'STREETTYPE_UA' => 'StreetType UA',
            'STREETTYPE_EN' => 'StreetType EN',
            'HOUSENUMBER' => '6A',
            'ADDRESS' => '123 Main Street',
            'LONGITUDE' => '50.123456',
            'LATTITUDE' => '30.654321',
            'IS_CASH' => '1',
            'IS_DHL' => '0',
            'IS_SMARTBOX' => '1',
            'PELPEREKAZY' => '0',
            'IS_FLAGMAN' => '1',
            'POSTTERMINAL' => '0',
            'IS_AUTOMATED' => '1',
            'IS_SECURITY' => '0',
            'LOCK_CODE' => '789',
            'LOCK_UA' => 'LockReason UA',
            'LOCK_EN' => 'LockReason EN',
            'PHONE' => '123-456-7890',
            'ISVPZ' => '1',
            'MEREZA_NUMBER' => '111',
            'TECHINDEX' => '222',
        ];

        $postOfficeSettlement = PostOfficeSettlement::fromResponseEntry($entry);

        $this->assertInstanceOf(PostOfficeSettlement::class, $postOfficeSettlement);
        $this->assertEquals(1, $postOfficeSettlement->getId());
        $this->assertEquals('Main Office', $postOfficeSettlement->getName());
        $this->assertEquals('MO', $postOfficeSettlement->getShortName());
        $this->assertEquals('Office Type', $postOfficeSettlement->getType());
        $this->assertEquals('OT', $postOfficeSettlement->getShortType());
        $this->assertEquals('OTA', $postOfficeSettlement->getTypeAcronym());
        $this->assertEquals(2, $postOfficeSettlement->getParentId());
        $this->assertEquals(3, $postOfficeSettlement->getCityId());
        // Assert multilingual fields
        $this->assertEquals(
            ['ua' => 'CityName UA', 'en' => 'CityName EN'],
            $postOfficeSettlement->getCity()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'CityType UA', 'en' => 'CityType EN'],
            $postOfficeSettlement->getCityType()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'ShortCityType UA', 'en' => 'ShortCityType EN'],
            $postOfficeSettlement->getShortCityType()->getByLangOrArray()
        );
        $this->assertEquals(123456, $postOfficeSettlement->getPostIndex());
        $this->assertEquals(4, $postOfficeSettlement->getRegionId());
        $this->assertEquals(
            ['ua' => 'RegionName UA', 'en' => 'RegionName EN'],
            $postOfficeSettlement->getRegion()->getByLangOrArray()
        );
        $this->assertEquals(5, $postOfficeSettlement->getDistrictId());
        $this->assertEquals(
            ['ua' => 'DistrictName UA', 'en' => 'DistrictName EN'],
            $postOfficeSettlement->getDistrict()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'StreetName UA', 'en' => 'StreetName EN'],
            $postOfficeSettlement->getStreet()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'StreetType UA', 'en' => 'StreetType EN'],
            $postOfficeSettlement->getStreetType()->getByLangOrArray()
        );
        $this->assertEquals('6A', $postOfficeSettlement->getHouseNumber());
        $this->assertEquals('123 Main Street', $postOfficeSettlement->getAddress());
        $this->assertEquals(50.123456, $postOfficeSettlement->getLongitude());
        $this->assertEquals(30.654321, $postOfficeSettlement->getLatitude());
        $this->assertTrue($postOfficeSettlement->isCash());
        $this->assertFalse($postOfficeSettlement->isDhl());
        $this->assertTrue($postOfficeSettlement->isSmartbox());
        $this->assertFalse($postOfficeSettlement->isUrgentPostalTransfers());
        $this->assertTrue($postOfficeSettlement->isFlagman());
        $this->assertFalse($postOfficeSettlement->hasPostTerminal());
        $this->assertTrue($postOfficeSettlement->isAutomated());
        $this->assertFalse($postOfficeSettlement->isSecurity());
        $this->assertEquals(789, $postOfficeSettlement->getLockCode());
        $this->assertEquals(
            ['ua' => 'LockReason UA', 'en' => 'LockReason EN'],
            $postOfficeSettlement->getLock()->getByLangOrArray()
        );
        $this->assertEquals('123-456-7890', $postOfficeSettlement->getPhone());
        $this->assertTrue($postOfficeSettlement->isVpz());
        $this->assertEquals(111, $postOfficeSettlement->getMerezaNumber());
        $this->assertEquals(222, $postOfficeSettlement->getTechIndex());
    }

}
