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

    public function value(): string
    {
        return $this->value;
    }

}
