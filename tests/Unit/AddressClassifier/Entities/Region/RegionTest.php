<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\Region;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\Region\Region;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(Region::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class RegionTest extends TestCase
{
    private Region $region;
    private object $nameMock;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->nameMock = $this->createMock(StringMultilingualInterface::class);
        $this->nameMock->method('getByLangOrArray')->willReturn('Region Name');

        $this->region = new Region(
            id: 1,
            name: $this->nameMock,
            koatuu: 123456,
            katottg: 789012
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->region->getId());
    }

    public function testGetName(): void
    {
        $this->assertSame($this->nameMock, $this->region->getName());
    }

    public function testGetKoatuu(): void
    {
        $this->assertEquals(123456, $this->region->getKoatuu());
    }

    public function testGetKatottg(): void
    {
        $this->assertEquals(789012, $this->region->getKatottg());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Region Name',
            'katottg' => 789012,
            'koatuu' => 123456,
        ];
        $this->assertEquals($expected, $this->region->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'REGION_ID' => '2',
            'REGION_UA' => 'Region UA',
            'REGION_EN' => 'Region EN',
            'REGION_KOATUU' => '654321',
            'REGION_KATOTTG' => '210987'
        ];
        $region = Region::fromResponseEntry($entry);

        $this->assertInstanceOf(Region::class, $region);
        $this->assertEquals(2, $region->getId());
        $this->assertEquals(
            ['ua' => 'Region UA', 'en' => 'Region EN'],
            $region->getName()->getByLangOrArray()
        );
        $this->assertEquals(654321, $region->getKoatuu());
        $this->assertEquals(210987, $region->getKatottg());
    }

}
