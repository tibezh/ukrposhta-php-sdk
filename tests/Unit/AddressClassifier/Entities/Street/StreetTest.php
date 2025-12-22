<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier\Entities\Street;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\AddressClassifier\Entities\Street\Street;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(Street::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class StreetTest extends TestCase
{

    private Street $street;
    private object $nameMock;
    private object $typeMock;
    private object $shortTypeMock;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->nameMock = $this->createMock(StringMultilingualInterface::class);
        $this->nameMock->method('getByLangOrArray')->willReturn('Street Name');

        $this->typeMock = $this->createMock(StringMultilingualInterface::class);
        $this->typeMock->method('getByLangOrArray')->willReturn('Street Type');

        $this->shortTypeMock = $this->createMock(StringMultilingualInterface::class);
        $this->shortTypeMock->method('getByLangOrArray')->willReturn('Short Type');

        $this->street = new Street(
            id: 1,
            name: $this->nameMock,
            type: $this->typeMock,
            shortType: $this->shortTypeMock
        );
    }

    public function testGetId(): void
    {
        $this->assertEquals(1, $this->street->getId());
    }

    public function testGetName(): void
    {
        $this->assertSame($this->nameMock, $this->street->getName());
    }

    public function testGetType(): void
    {
        $this->assertSame($this->typeMock, $this->street->getType());
    }

    public function testGetShortType(): void
    {
        $this->assertSame($this->shortTypeMock, $this->street->getShortType());
    }

    public function testToArray(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Street Name',
            'type' => 'Street Type',
            'short_type' => 'Short Type',
        ];

        $this->assertEquals($expected, $this->street->toArray());
    }

    public function testFromResponseEntry(): void
    {
        $entry = [
            'STREET_ID' => '2',
            'STREET_UA' => 'street UA',
            'STREET_EN' => 'street EN',
            'STREETTYPE_UA' => 'street type UA',
            'STREETTYPE_EN' => 'street type EN',
            'SHORTSTREETTYPE_UA' => 'street short type UA',
            'SHORTSTREETTYPE_EN' => 'street short type EN',
        ];

        $street = Street::fromResponseEntry($entry);

        $this->assertInstanceOf(Street::class, $street);
        $this->assertEquals(2, $street->getId());
        $this->assertEquals(
            ['ua' => 'street UA', 'en' => 'street EN'],
            $street->getName()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'street type UA', 'en' => 'street type EN'],
            $street->getType()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => 'street short type UA', 'en' => 'street short type EN'],
            $street->getShortType()->getByLangOrArray()
        );
    }

}
