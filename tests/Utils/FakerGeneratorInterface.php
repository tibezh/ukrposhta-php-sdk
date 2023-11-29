<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Utils;

interface FakerGeneratorInterface
{
    /**
     * Generates random barcode.
     */
    public function barcode(): string;

    /**
     * Generates random digit or null.
     */
    public function randomDigitOrNull(): ?int;

    /**
     * Generates random string or null.
     */
    public function randomStringOrNull(): ?string;

    /**
     * Generates random sentence or null.
     */
    public function sentenceOrNull(int $length = 3): ?string;

    public function url(): string;

    public function randomDigit(): int;

    public function randomNumber(): int;

    public function word(): string;

    /**
     * @return array<int, string>|string
     */
    public function words(int $nb = 3, bool $asText = false): array|string;

    public function boolean(): bool;

    public function uuid(): string;

    /**
     * @param array<int, string> $array
     *
     * @return array<int, string>
     */
    public function randomElements(array $array = ['a', 'b', 'c'], int $count = 1, bool $allowDuplicates = false): array;

    public function address(): string;

    public function languageCode(): string;
}
