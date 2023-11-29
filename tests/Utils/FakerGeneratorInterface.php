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

  /**
   * @return string
   */
  public function url(): string;

  /**
   * @return int
   */
  public function randomDigit(): int;

  /**
   * @return int
   */
  public function randomNumber(): int;

  /**
   * @return string
   */
  public function word(): string;

  /**
   * @param int $nb
   * @param bool $asText
   *
   * @return array<int, string>|string
   */
  public function words(int $nb = 3, bool $asText = false): array|string;

  /**
   * @return bool
   */
  public function boolean(): bool;

  /**
   * @return string
   */
  public function uuid(): string;

  /**
   * @param array<int, string> $array
   * @param int $count
   * @param bool $allowDuplicates
   * @return array<int, string>
   */
  public function randomElements(array $array = ['a', 'b', 'c'], int $count = 1, bool $allowDuplicates = false): array;

  /**
   * @return string
   */
  public function address(): string;

  /**
   * @return string
   */
  public function languageCode(): string;

}
