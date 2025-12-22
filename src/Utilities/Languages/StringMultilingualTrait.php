<?php

declare(strict_types=1);

namespace Ukrposhta\Utilities\Languages;

/**
 *
 */
trait StringMultilingualTrait
{

    /**
     * @param array<string, mixed> $entry
     * @param string $keyPattern
     *   Pattern to the key, for example "CITYTYPE_#lang".
     * @param LanguagesEnumInterface $defaultLanguage
     * @param bool $languageKeyInUppercase
     *
     * @return StringMultilingualInterface
     */
    protected static function getMultilingualStringFromEntryAndKey(
        array $entry,
        string $keyPattern,
        LanguagesEnumInterface $defaultLanguage = LanguagesEnum::UA,
        bool $languageKeyInUppercase = true,
    ): StringMultilingualInterface {
        $strings = $keys = [];

        // Build needed keys in the entry.
        foreach (LanguagesEnum::cases() as $language) {
            $languageKey = $language->value;
            if ($languageKeyInUppercase) {
                $languageKey = strtoupper($languageKey);
            }
            $keys[$language->value] = str_replace('#lang', $languageKey, $keyPattern);
        }

        // Check values in the Entry.
        foreach ($keys as $languageKey => $key) {
            if (isset($entry[$key])) {
                $strings[$languageKey] = $entry[$key];
            }
        }

        // Create String Multilingual object from strings.
        return new StringMultilingual($strings, $defaultLanguage);
    }

}
