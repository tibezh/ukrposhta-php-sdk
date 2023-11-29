<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

/**
 *
 */
trait FakerGeneratorTrait {

  /**
   * @var FakerGeneratorInterface|null
   */
  protected ?FakerGeneratorInterface $fakerGenerator = null;

  /**
   * @return FakerGeneratorInterface
   */
  protected function fakerGenerator(): FakerGeneratorInterface {
    if (!$this->fakerGenerator) {
      $this->fakerGenerator = FakerFactory::createCustom();
    }
    return $this->fakerGenerator;
  }

}
