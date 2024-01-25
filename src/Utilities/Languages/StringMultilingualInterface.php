<?php

declare(strict_types=1);

namespace Ukrposhta\Utilities\Languages;

/**
 *
 */
interface StringMultilingualInterface
{

  /**
   * @return LanguagesEnumInterface
   */
  public function getDefaultLanguage(): LanguagesEnumInterface;

  /**
   * @param LanguagesEnumInterface $language
   *
   * @return bool
   */
  public function hasByLanguage(LanguagesEnumInterface $language): bool;

  /**
   * @param LanguagesEnumInterface $language
   *
   * @return string|null
   */
  public function getByLanguage(LanguagesEnumInterface $language): ?string;

  /**
   * @param LanguagesEnumInterface|null $language
   *
   * @return string|array|null
   */
  public function getByLangOrArray(?LanguagesEnumInterface $language): string|array|null;

  /**
   * @return LanguagesEnumInterface[]
   */
  public function getAvailableLanguages(): array;

  /**
   * @return bool
   */
  public function isEmpty(): bool;

  /**
   * @return array<string, string>
   */
  public function toArray(): array;

}
