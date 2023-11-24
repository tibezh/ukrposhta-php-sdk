<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

use Faker\Generator;

class FakerGenerator extends Generator implements FakerGeneratorInterface {


  /**
   * @inheritDoc
   */
  public function barcode(): string
  {
    return $this->numerify('barcode-#############');
  }

  /**
   * @inheritDoc
   */
  public function randomDigitOrNull(): ?int
  {
    return mt_rand(0, 1) === 1 ? $this->randomDigit() : NULL;
  }

  /**
   * @inheritDoc
   */
  public function randomStringOrNull(): ?string
  {
    return mt_rand(0, 1) === 1 ? $this->lexify() : NULL;
  }

  /**
   * @inheritDoc
   */
  public function sentenceOrNull(int $length = 3): ?string
  {
    return mt_rand(0, 1) === 1 ? $this->sentence($length) : NULL;
  }

}
