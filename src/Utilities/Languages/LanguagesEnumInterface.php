<?php

declare(strict_types=1);

namespace Ukrposhta\Utilities\Languages;

/**
 *
 */
interface LanguagesEnumInterface
{

  /**
   * Gets property suffix.
   *
   * @return string
   *   The suffix of the property.
   */
  public function propSuffix(): string;

  /**
   * Gets request suffix
   *
   * @return string
   *   The suffix of the request.
   */
  public function requestSuffix(): string;

}
