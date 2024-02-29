<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\City;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\City\City;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(City::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class CityTest extends TestCase
{
    private City $city;
    private object $nameMock;
    private object $typeMock;
    private object $shortTypeMock;

    protected function setUp(): void
    {
        // Mock the StringMultilingualInterface for name, type, and shortType
        $this->nameMock = $this->createMock(StringMultilingualInterface::class);
        $this->typeMock = $this->createMock(StringMultilingualInterface::class);
        $this->shortTypeMock = $this->createMock(StringMultilingualInterface::class);

        // Configure the mocks to return a specific string for testing
        $this->nameMock->method('getByLangOrArray')->willReturn('CityName');
        $this->typeMock->method('getByLangOrArray')->willReturn('CityType');
        $this->shortTypeMock->method('getByLangOrArray')->willReturn('ShortCityType');

        $this->city = new City(
            id: 1,
            name: $this->nameMock,
            type: $this->typeMock,
            shortType: $this->shortTypeMock,
            katottg: 100,
            koatuu: 200,
            longitude: 30.5,
            latitude: 50.5,
            population: 150000
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->city->getId());
        $this->assertSame($this->nameMock, $this->city->getName());
        $this->assertSame($this->typeMock, $this->city->getType());
        $this->assertSame($this->shortTypeMock, $this->city->getShortType());
        $this->assertEquals(100, $this->city->getKatottg());
        $this->assertEquals(200, $this->city->getKoatuu());
        $this->assertEquals(30.5, $this->city->getLongitude());
        $this->assertEquals(50.5, $this->city->getLatitude());
        $this->assertEquals(150000, $this->city->getPopulation());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'CityName',
            'type' => 'CityType',
            'short_type' => 'ShortCityType',
            'katottg' => 100,
            'koatuu' => 200,
            'longitude' => 30.5,
            'latitude' => 50.5,
            'population' => 150000,
        ];

        $this->assertEquals($expected, $this->city->toArray(LanguagesEnum::UA));
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'CITY_ID' => '100',
            'CITY_UA' => 'CityNameUa',
            'CITY_EN' => 'CityNameEn',
            'CITYTYPE_UA' => 'CityTypeUa',
            'CITYTYPE_EN' => 'CityTypeEn',
            'SHORTCITYTYPE_UA' => 'CityShortTypeUa',
            'SHORTCITYTYPE_EN' => 'CityShortTypeEn',
            'CITY_KATOTTG' => '123',
            'CITY_KOATUU' => '456',
            'LONGITUDE' => '30.123',
            'LATTITUDE' => '50.456',
            'POPULATION' => '7890'
        ];

        $city = City::fromResponseEntry($entry);

        // Assert: Verify the properties of the constructed City object
        $this->assertInstanceOf(City::class, $city);
        $this->assertEquals(100, $city->getId());
        $this->assertEquals(
            ['ua' => 'CityNameUa', 'en' => 'CityNameEn'],
            $city->getName()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'CityTypeUa', 'en' => 'CityTypeEn'],
            $city->getType()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'CityShortTypeUa', 'en' => 'CityShortTypeEn'],
            $city->getShortType()->getByLangOrArray()
        );
        $this->assertEquals(123, $city->getKatottg());
        $this->assertEquals(456, $city->getKoatuu());
        $this->assertEquals(30.123, $city->getLongitude());
        $this->assertEquals(50.456, $city->getLatitude());
        $this->assertEquals(7890, $city->getPopulation());
    }

}
