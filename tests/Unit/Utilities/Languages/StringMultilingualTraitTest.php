<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Utilities\Languages;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingual;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

#[CoversClass(StringMultilingualTrait::class)]
#[CoversClass(LanguagesEnum::class)]
#[CoversClass(StringMultilingual::class)]
#[Small]
class StringMultilingualTraitTest extends TestCase
{

    public function testGetMultilingualStringFromEntryAndKey(): void
    {
        $class = new class {
            use StringMultilingualTrait;

            /** @phpstan-ignore-next-line */
            public static function getMultilingualStringFromEntryAndKeyMethod(
                array $entry,
                string $keyPattern,
                LanguagesEnumInterface $defaultLanguage = LanguagesEnum::UA,
                bool $languageKeyInUppercase = true
            ): StringMultilingualInterface {
                return self::getMultilingualStringFromEntryAndKey($entry, $keyPattern, $defaultLanguage, $languageKeyInUppercase);
            }
        };

        $entry1 = ['TEST_EN' => 'abc'];
        $result1 = $class::getMultilingualStringFromEntryAndKeyMethod($entry1, 'TEST_#lang');
        $this->assertSame('abc', $result1->getByLanguage(LanguagesEnum::EN));

        $entry2 = ['TEST_EN' => 'bca', 'TEST_UA' => 'abc'];
        $result2 = $class::getMultilingualStringFromEntryAndKeyMethod($entry2, 'TEST_#lang');
        $this->assertSame('bca', $result2->getByLanguage(LanguagesEnum::EN));
        $this->assertSame('abc', $result2->getByLanguage(LanguagesEnum::UA));
    }

}
