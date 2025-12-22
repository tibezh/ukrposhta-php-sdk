<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\City;

use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class City implements CityInterface
{

    use StringMultilingualTrait;

    /**
     * City constructor.
     *
     * @param int $id
     *   City ID.
     * @param StringMultilingualInterface $name
     * @param StringMultilingualInterface $type
     * @param StringMultilingualInterface $shortType
     * @param int $katottg
     *   Katottg code.
     * @param int $koatuu
     *   Koatuu code.
     * @param float $longitude
     *   City longitude.
     * @param float $latitude
     *   City latitude.
     * @param int $population
     *   City population.
     */
    public function __construct(
        protected readonly int $id,
        protected readonly StringMultilingualInterface $name,
        protected readonly StringMultilingualInterface $type,
        protected readonly StringMultilingualInterface $shortType,
        protected readonly int $katottg,
        protected readonly int $koatuu,
        protected readonly float $longitude,
        protected readonly float $latitude,
        protected readonly int $population,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): StringMultilingualInterface
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getType(): StringMultilingualInterface
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function getShortType(LanguagesEnumInterface $language = LanguagesEnum::UA): StringMultilingualInterface
    {
        return $this->shortType;
    }

    /**
     * {@inheritDoc}
     */
    public function getKatottg(): int
    {
        return $this->katottg;
    }

    /**
     * {@inheritDoc}
     */
    public function getKoatuu(): int
    {
        return $this->koatuu;
    }

    /**
     * {@inheritDoc}
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * {@inheritDoc}
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * {@inheritDoc}
     */
    public function getPopulation(): int
    {
        return $this->population;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(?LanguagesEnumInterface $language = null): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName()->getByLangOrArray($language),
          'type' => $this->getType()->getByLangOrArray($language),
          'short_type' => $this->getShortType()->getByLangOrArray($language),
          'katottg' => $this->getKatottg(),
          'koatuu' => $this->getKoatuu(),
          'longitude' => $this->getLongitude(),
          'latitude' => $this->getLatitude(),
          'population' => $this->getPopulation(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): CityInterface
    {
        return new City(
            id: (int) $entry['CITY_ID'],
            name: self::getMultilingualStringFromEntryAndKey($entry, 'CITY_#lang'),
            type: self::getMultilingualStringFromEntryAndKey($entry, 'CITYTYPE_#lang'),
            shortType: self::getMultilingualStringFromEntryAndKey($entry, 'SHORTCITYTYPE_#lang'),
            katottg: (int) $entry['CITY_KATOTTG'],
            koatuu: (int) $entry['CITY_KOATUU'],
            longitude: (float) $entry['LONGITUDE'],
            latitude: (float) $entry['LATTITUDE'],
            population: (int) $entry['POPULATION']
        );
    }

}
