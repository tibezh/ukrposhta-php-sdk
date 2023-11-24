<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

interface FakerGeneratorInterface {

  /**
   * Generates random barcode.
   *
   * @return string
   */
  public function barcode(): string;

  /**
   * Generates random digit or null.
   *
   * @return int|null
   */
  public function randomDigitOrNull(): ?int;

  /**
   * Generates random string or null.
   *
   * @return string|null
   */
  public function randomStringOrNull(): ?string;

  /**
   * Generates random sentence or null.
   *
   * @param int $length
   *
   * @return string|null
   */
  public function sentenceOrNull(int $length = 3): ?string;

}
