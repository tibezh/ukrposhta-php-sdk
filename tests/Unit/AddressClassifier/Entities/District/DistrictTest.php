<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\District;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\District\District;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(District::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class DistrictTest extends TestCase
{

    private District $district;
    private object $nameMock;

    protected function setUp(): void
    {
        $this->nameMock = $this->createMock(StringMultilingualInterface::class);

        // Mocking the behavior of the name object
        $this->nameMock->method('getByLangOrArray')->willReturn('District Name');

        $this->district = new District(
            id: 1,
            name: $this->nameMock,
            koatuu: 123456,
            katottg: 78910
        );
    }

    public function testGetters(): void
    {
        $this->assertEquals(1, $this->district->getId());
        $this->assertSame($this->nameMock, $this->district->getName());
        $this->assertEquals(123456, $this->district->getKoatuu());
        $this->assertEquals(78910, $this->district->getKatottg());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'District Name',
            'koatuu' => 123456,
            'katottg' => 78910,
        ];

        $this->assertEquals($expected, $this->district->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'DISTRICT_ID' => '1',
            'DISTRICT_UA' => 'DistrictUa',
            'DISTRICT_EN' => 'DistrictEn',
            'DISTRICT_KOATUU' => '123456',
            'DISTRICT_KATOTTG' => '78910',
        ];

        $district = District::fromResponseEntry($entry);

        $this->assertInstanceOf(District::class, $district);
        $this->assertEquals($entry['DISTRICT_ID'], $district->getId());
        $this->assertEquals(
            ['ua' => 'DistrictUa', 'en' => 'DistrictEn'],
            $district->getName()->getByLangOrArray()
        );
        $this->assertEquals($entry['DISTRICT_KOATUU'], $district->getKoatuu());
        $this->assertEquals($entry['DISTRICT_KATOTTG'], $district->getKatottg());
    }

}
