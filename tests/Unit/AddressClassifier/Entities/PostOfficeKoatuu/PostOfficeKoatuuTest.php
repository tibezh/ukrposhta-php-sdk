<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\PostOfficeKoatuu;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu\PostOfficeKoatuu;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(PostOfficeKoatuu::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Medium]
class PostOfficeKoatuuTest extends TestCase
{

    private PostOfficeKoatuu $postOfficeKoatuu;
    private object $cityTypeNameMock;
    private object $cityVpzNameMock;
    private object $streetVpzNameMock;
    private object $postOfficeNameMock;
    private object $postOfficeDetailsMock;
    private object $lockNameMock;

    protected function setUp(): void
    {

        $this->cityTypeNameMock = $this->createMock(StringMultilingualInterface::class);
        $this->cityTypeNameMock->method('getByLangOrArray')->willReturn('City Type Name');

        $this->cityVpzNameMock = $this->createMock(StringMultilingualInterface::class);
        $this->cityVpzNameMock->method('getByLangOrArray')->willReturn('City VPZ Name');

        $this->streetVpzNameMock = $this->createMock(StringMultilingualInterface::class);
        $this->streetVpzNameMock->method('getByLangOrArray')->willReturn('Street VPZ Name');

        $this->postOfficeNameMock = $this->createMock(StringMultilingualInterface::class);
        $this->postOfficeNameMock->method('getByLangOrArray')->willReturn('Post Office Name');

        $this->postOfficeDetailsMock = $this->createMock(StringMultilingualInterface::class);
        $this->postOfficeDetailsMock->method('getByLangOrArray')->willReturn('Post Office Details');

        $this->lockNameMock = $this->createMock(StringMultilingualInterface::class);
        $this->lockNameMock->method('getByLangOrArray')->willReturn('Lock Name');

        $this->postOfficeKoatuu = new PostOfficeKoatuu(
            postCode: 12345,
            postIndex: 54321,
            cityId: 1,
            cityKoatuu: 2,
            cityKatottg: 3,
            cityVpzId: 4,
            cityTypeName: $this->cityTypeNameMock,
            cityVpzName: $this->cityVpzNameMock,
            cityVpzKoatuu: 5,
            streetVpzId: 7,
            streetVpzName: $this->streetVpzNameMock,
            houseNumber: '8a',
            postOfficeId: 8,
            postOfficeName: $this->postOfficeNameMock,
            postOfficeDetails: $this->postOfficeDetailsMock,
            phoneNumber: '888',
            longitude: 10.123,
            latitude: -11.456,
            typeId: 9,
            typeAcronymName: 'type acronym name',
            typeLongName: 'type long name',
            hasPostTerminal: true,
            isAutomated: false,
            isSecurity: false,
            lockCode: 10,
            lockName: $this->lockNameMock,
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(12345, $this->postOfficeKoatuu->getPostCode());
        $this->assertEquals(54321, $this->postOfficeKoatuu->getPostIndex());
        $this->assertEquals(1, $this->postOfficeKoatuu->getCityId());
        $this->assertEquals(2, $this->postOfficeKoatuu->getCityKoatuu());
        $this->assertEquals(3, $this->postOfficeKoatuu->getCityKatottg());
        $this->assertEquals(4, $this->postOfficeKoatuu->getCityVpzId());
        $this->assertEquals($this->cityTypeNameMock, $this->postOfficeKoatuu->getCityTypeName());
        $this->assertEquals($this->cityVpzNameMock, $this->postOfficeKoatuu->getCityVpzName());
        $this->assertEquals(5, $this->postOfficeKoatuu->getCityVpzKoatuu());
        $this->assertEquals(7, $this->postOfficeKoatuu->getStreetVpzId());
        $this->assertEquals($this->streetVpzNameMock, $this->postOfficeKoatuu->getStreetVpzName());
        $this->assertEquals('8a', $this->postOfficeKoatuu->getHouseNumber());
        $this->assertEquals(8, $this->postOfficeKoatuu->getPostOfficeId());
        $this->assertEquals($this->postOfficeNameMock, $this->postOfficeKoatuu->getPostOfficeName());
        $this->assertEquals($this->postOfficeDetailsMock, $this->postOfficeKoatuu->getPostOfficeDetails());
        $this->assertEquals('888', $this->postOfficeKoatuu->getPhoneNumber());
        $this->assertEquals(10.123, $this->postOfficeKoatuu->getLongitude());
        $this->assertEquals(-11.456, $this->postOfficeKoatuu->getLatitude());
        $this->assertEquals(9, $this->postOfficeKoatuu->getTypeId());
        $this->assertEquals('type acronym name', $this->postOfficeKoatuu->getTypeAcronymName());
        $this->assertEquals('type long name', $this->postOfficeKoatuu->getTypeLongName());
        $this->assertTrue($this->postOfficeKoatuu->hasPostTerminal());
        $this->assertFalse($this->postOfficeKoatuu->isAutomated());
        $this->assertFalse($this->postOfficeKoatuu->isSecurity());
        $this->assertEquals(10, $this->postOfficeKoatuu->getLockCode());
        $this->assertEquals($this->lockNameMock, $this->postOfficeKoatuu->getLockName());
    }

    public function testToArray(): void
    {
        $expectedArray = [
            'post_code' => 12345,
            'post_index' => 54321,
            'city_id' => 1,
            'city_koatuu' => 2,
            'city_katottg' => 3,
            'city_vpz_id' => 4,
            'city_type_name' => 'City Type Name',
            'city_vpz_name' => 'City VPZ Name',
            'city_vpz_koatuu' => 5,
            'street_vpz_id' => 7,
            'street_vpz_name' => 'Street VPZ Name',
            'house_number' => '8a',
            'post_office_id' => 8,
            'post_office_name' => 'Post Office Name',
            'post_office_details' => 'Post Office Details',
            'phone_number' => '888',
            'longitude' => 10.123,
            'latitude' => -11.456,
            'type_id' => 9,
            'type_acronym_name' => 'type acronym name',
            'type_long_name' => 'type long name',
            'has_post_terminal' => true,
            'is_automated' => false,
            'is_security' => false,
            'lock_code' => 10,
            'lock_name' => 'Lock Name',
        ];
        $this->assertEquals($expectedArray, $this->postOfficeKoatuu->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'POSTCODE' => '1',
            'POSTINDEX' => '2',
            'CITY_ID' => '3',
            'CITY_KOATUU' => '4',
            'CITY_KATOTTG' => '5',
            'CITY_VPZ_ID' => '6',
            'CITY_UA_TYPE' => 'city UA type',
            'CITY_EN_TYPE' => 'city EN type',
            'CITY_UA_VPZ' => 'city UA VPZ',
            'CITY_EN_VPZ' => 'city EN VPZ',
            'CITY_VPZ_KOATUU' => '5',
            'STREET_ID_VPZ' => '7',
            'STREET_UA_VPZ' => 'street UA VPZ',
            'STREET_EN_VPZ' => 'street EN VPZ',
            'HOUSENUMBER' => '8a',
            'POSTOFFICE_ID' => '9',
            'POSTOFFICE_UA' => 'post office UA',
            'POSTOFFICE_EN' => 'post office EN',
            'POSTOFFICE_UA_DETAILS' => 'post office UA details',
            'POSTOFFICE_EN_DETAILS' => 'post office EN details',
            'PHONE' => '888',
            'LONGITUDE' => '54.6542',
            'LATTITUDE' => '-10.556',
            'TYPE_ID' => '10',
            'TYPE_ACRONYM' => 'type acronym',
            'TYPE_LONG' => 'type long',
            'POSTTERMINAL' => '1',
            'ISAUTOMATED' => '0',
            'IS_SECURITY' => '0',
            'LOCK_CODE' => '11',
            'LOCK_UA' => 'lock UA',
            'LOCK_EN' => 'lock EN',
        ];

        $postOfficeKoatuu = PostOfficeKoatuu::fromResponseEntry($entry);

        $this->assertInstanceOf(PostOfficeKoatuu::class, $postOfficeKoatuu);
        $this->assertEquals(1, $postOfficeKoatuu->getPostCode());
        $this->assertEquals(2, $postOfficeKoatuu->getPostIndex());
        $this->assertEquals(3, $postOfficeKoatuu->getCityId());
        $this->assertEquals(4, $postOfficeKoatuu->getCityKoatuu());
        $this->assertEquals(5, $postOfficeKoatuu->getCityKatottg());
        $this->assertEquals(6, $postOfficeKoatuu->getCityVpzId());
        $this->assertEquals(
            ['ua' => 'city UA type', 'en' => 'city EN type'],
            $postOfficeKoatuu->getCityTypeName()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'city UA VPZ', 'en' => 'city EN VPZ'],
            $postOfficeKoatuu->getCityVpzName()->getByLangOrArray()
        );
        $this->assertEquals(5, $postOfficeKoatuu->getCityVpzKoatuu());
        $this->assertEquals(7, $postOfficeKoatuu->getStreetVpzId());
        $this->assertEquals(
            ['ua' => 'street UA VPZ', 'en' => 'street EN VPZ'],
            $postOfficeKoatuu->getStreetVpzName()->getByLangOrArray()
        );
        $this->assertEquals('8a', $postOfficeKoatuu->getHouseNumber());
        $this->assertEquals(9, $postOfficeKoatuu->getPostOfficeId());
        $this->assertEquals(
            ['ua' => 'post office UA details', 'en' => 'post office EN details'],
            $postOfficeKoatuu->getPostOfficeDetails()->getByLangOrArray()
        );
        $this->assertEquals('888', $postOfficeKoatuu->getPhoneNumber());
        $this->assertEquals(54.6542, $postOfficeKoatuu->getLongitude());
        $this->assertEquals(-10.556, $postOfficeKoatuu->getLatitude());
        $this->assertEquals(10, $postOfficeKoatuu->getTypeId());
        $this->assertEquals('type acronym', $postOfficeKoatuu->getTypeAcronymName());
        $this->assertEquals('type long', $postOfficeKoatuu->getTypeLongName());
        $this->assertTrue($postOfficeKoatuu->hasPostTerminal());
        $this->assertFalse($postOfficeKoatuu->isAutomated());
        $this->assertFalse($postOfficeKoatuu->isSecurity());
        $this->assertEquals(11, $postOfficeKoatuu->getLockCode());
        $this->assertEquals(
            ['ua' => 'lock UA', 'en' => 'lock EN'],
            $postOfficeKoatuu->getLockName()->getByLangOrArray()
        );
    }

}
