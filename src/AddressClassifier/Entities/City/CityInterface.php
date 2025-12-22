<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 * Provides required methods for City entity.
 */
interface CityInterface extends EntityInterface
{

    /**
     * Gets city ID.
     *
     * @return int
     *   ID of the city.
     */
    public function getId(): int;

    /**
     * City name.
     *
     * @return StringMultilingualInterface
     */
    public function getName(): StringMultilingualInterface;

    /**
     * City type.
     *
     * @return StringMultilingualInterface
     */
    public function getType(): StringMultilingualInterface;

    /**
     * City short type.
     *
     * @return StringMultilingualInterface
     */
    public function getShortType(): StringMultilingualInterface;

    /**
     * Gets city katottg code.
     *
     * @return int
     *   The city katottg code
     */
    public function getKatottg(): int;

    /**
     * Gets city koatuu code.
     *
     * @return int
     *   The city koatuu code
     */
    public function getKoatuu(): int;

    /**
     * Gets city longitude.
     *
     * @return float
     *   Longitude of the city.
     */
    public function getLongitude(): float;

    /**
     * Gets city latitude.
     *
     * @return float
     *   Latitude of the city.
     */
    public function getLatitude(): float;

    /**
     * Gets city population.
     *
     * @return int
     *   Population of the city.
     */
    public function getPopulation(): int;

    /**
     * Gets an associative array version of the City.
     *
     * @param LanguagesEnumInterface|null $language
     *   Language of the value to return, NULL by default which returns all values.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(?LanguagesEnumInterface $language = null): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): CityInterface;

}
