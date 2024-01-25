<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Utilities\Languages;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

#[CoversClass(StringMultilingual::class)]
#[CoversClass(LanguagesEnum::class)]
#[Small]
class StringMultilingualTest extends TestCase
{

    public function testConstructor(): void
    {
        $obj = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::UA);
        $this->assertInstanceOf(StringMultilingualInterface::class, $obj);
    }

    public function test__toString(): void
    {
        $obj1 = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::UA);
        $string1 = (string) $obj1;
        $this->assertSame('abc', $string1);

        $obj2 = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::EN);
        $string2 = (string) $obj2;
        $this->assertSame('', $string2);
    }

    public function testHasByLanguage(): void
    {
        $obj = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::UA);
        $this->assertTrue($obj->hasByLanguage(LanguagesEnum::UA));
        $this->assertFalse($obj->hasByLanguage(LanguagesEnum::EN));
    }

    public function testGetByLangOrArray(): void
    {
        $obj1 = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::UA);
        $data1 = $obj1->getByLangOrArray(null);
        $this->assertSame([LanguagesEnum::UA->value() => 'abc'], $data1);

        $obj2 = new StringMultilingual([LanguagesEnum::EN->value() => 'bcz'], LanguagesEnum::UA);
        $data2 = $obj2->getByLangOrArray(LanguagesEnum::UA);
        $this->assertNull($data2);

        $arr = [LanguagesEnum::UA->value() => 'abc', LanguagesEnum::EN->value() => 'bca'];
        $obj3 = new StringMultilingual($arr, LanguagesEnum::UA);
        $data3 = $obj3->getByLangOrArray();
        $this->assertSame($arr, $data3);
    }

    public function testIsEmpty(): void
    {
        $obj1 = new StringMultilingual([LanguagesEnum::UA->value() => 'abc'], LanguagesEnum::UA);
        $this->assertFalse($obj1->isEmpty());

        $obj2 = new StringMultilingual([], LanguagesEnum::UA);
        $this->assertTrue($obj2->isEmpty());
    }

}
