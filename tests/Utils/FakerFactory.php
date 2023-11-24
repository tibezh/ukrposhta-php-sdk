<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

use Faker\Factory;

class FakerFactory extends Factory {

  /**
   * {@inheritDoc}
   */
  public static function create($locale = self::DEFAULT_LOCALE)
  {
    $generator = new FakerGenerator();

    foreach (static::$defaultProviders as $provider) {
      $providerClassName = self::getProviderClassname($provider, $locale);
      $generator->addProvider(new $providerClassName($generator));
    }

    return $generator;
  }

}
