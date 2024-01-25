<?php

declare(strict_types=1);

namespace Ukrposhta\Utilities\Languages;

/**
 *
 */
class StringMultilingual implements StringMultilingualInterface
{

  /**
   * @param array<string, string> $strings
   *   Key as language
   * @param LanguagesEnumInterface $defaultLanguage
   */
  public function __construct(
    protected readonly array $strings,
    protected readonly LanguagesEnumInterface $defaultLanguage
  ) {
  }

  public function __toString(): string
  {
    return $this->getByLanguage($this->getDefaultLanguage()) ?? '';
  }

  /**
   * {@inheritDoc}
   */
  public function hasByLanguage(LanguagesEnumInterface $language): bool
  {
    return isset($this->strings[$language->value]);
  }

  /**
   * {@inheritDoc}
   */
  public function getByLanguage(LanguagesEnumInterface $language): ?string
  {
    return $this->strings[$language->value] ?? null;
  }

  /**
   * {@inheritDoc}
   */
  public function getByLangOrArray(?LanguagesEnumInterface $language): string|array|null
  {
    return $language ? $this->getByLanguage($language) : $this->toArray();
  }

  /**
   * {@inheritDoc}
   */
  public function getDefaultLanguage(): LanguagesEnumInterface
  {
    return $this->defaultLanguage;
  }

  /**
   * {@inheritDoc}
   */
  public function getAvailableLanguages(): array
  {
    return array_map(
      static fn($v) => LanguagesEnum::from($v),
      array_keys($this->strings)
    );
  }

  /**
   * {@inheritDoc}
   */
  public function isEmpty(): bool
  {
    return empty($this->strings);
  }

  public function toArray(): array
  {
    $strings = [];
    foreach ($this->getAvailableLanguages() as $language) {
      $strings[$language->value] = $this->strings[$language->value];
    }
    return $strings;
  }

}
