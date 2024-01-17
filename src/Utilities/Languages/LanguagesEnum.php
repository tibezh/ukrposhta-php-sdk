<?php

declare(strict_types=1);

namespace Ukrposhta\Utilities\Languages;

/**
 *
 */
enum LanguagesEnum: string implements LanguagesEnumInterface
{

  case UA = 'ua';
  case EN = 'en';

  /**
   * {@inheritDoc}
   */
  public function propSuffix(): string
  {
    // With the first letter in uppercase.
    return ucfirst($this->value);
  }

  /**
   * {@inheritDoc}
   */
  public function requestSuffix(): string
  {
    return match ($this) {
      LanguagesEnum::UA => '',
      LanguagesEnum::EN => '_' . $this->value,
    };
  }

}
