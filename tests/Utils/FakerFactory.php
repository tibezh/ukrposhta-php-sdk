<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

use Faker\Factory;

class FakerFactory extends Factory
{
    public static function createCustom(string $locale = self::DEFAULT_LOCALE): FakerGeneratorInterface
    {
        $generator = new FakerGenerator();

        foreach (static::$defaultProviders as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;
    }
}
