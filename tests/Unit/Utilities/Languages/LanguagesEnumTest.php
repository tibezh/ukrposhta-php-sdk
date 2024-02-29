<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Utilities\Languages;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Utilities\Languages\LanguagesEnum;

#[CoversClass(LanguagesEnum::class)]
#[Small]
class LanguagesEnumTest extends TestCase
{

    public function testValue(): void
    {
        $this->assertSame('ua', LanguagesEnum::UA->value());
        $this->assertSame('en', LanguagesEnum::EN->value());
    }

}
