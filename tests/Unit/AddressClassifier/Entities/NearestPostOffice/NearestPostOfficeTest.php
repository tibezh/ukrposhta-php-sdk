<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\NearestPostOffice;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOffice;

#[CoversClass(NearestPostOffice::class)]
#[Small]
class NearestPostOfficeTest extends TestCase
{

    private NearestPostOffice $nearestPostOffice;

    protected function setUp(): void
    {
        $this->nearestPostOffice = new NearestPostOffice(
            id: 1,
            cityName: 'Test City',
            address: 'Test Address',
            filialName: 'Test Filial',
            distance: 100
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->nearestPostOffice->getId());
        $this->assertEquals('Test City', $this->nearestPostOffice->getCityName());
        $this->assertEquals('Test Address', $this->nearestPostOffice->getAddress());
        $this->assertEquals('Test Filial', $this->nearestPostOffice->getFilialName());
        $this->assertEquals(100, $this->nearestPostOffice->getDistance());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'city_name' => 'Test City',
            'address' => 'Test Address',
            'filial_name' => 'Test Filial',
            'distance' => 100,
        ];

        $this->assertEquals($expected, $this->nearestPostOffice->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'ID' => '2',
            'CITYNAME' => 'Another City',
            'ADDRESS' => 'Another Address',
            'POSTFILIALNAME' => 'Another Filial',
            'DISTANCE' => '200',
        ];

        $nearestPostOffice = NearestPostOffice::fromResponseEntry($entry);

        $this->assertInstanceOf(NearestPostOffice::class, $nearestPostOffice);
        $this->assertEquals($entry['ID'], $nearestPostOffice->getId());
        $this->assertEquals($entry['CITYNAME'], $nearestPostOffice->getCityName());
        $this->assertEquals($entry['ADDRESS'], $nearestPostOffice->getAddress());
        $this->assertEquals($entry['POSTFILIALNAME'], $nearestPostOffice->getFilialName());
        $this->assertEquals($entry['DISTANCE'], $nearestPostOffice->getDistance());
    }

}
