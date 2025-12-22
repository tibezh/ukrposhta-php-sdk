<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Region;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 * Region main class.
 */
class Region implements RegionInterface
{

    use StringMultilingualTrait;

    /**
     * Region constructor.
     *
     * @param int $id
     *   Region ID.
     * @param StringMultilingualInterface $name
     * @param int $koatuu
     *   Region KOATUU code.
     * @param int $katottg
     *   Region KATOTTG code.
     */
    public function __construct(
        protected readonly int $id,
        protected readonly StringMultilingualInterface $name,
        protected readonly int $koatuu,
        protected readonly int $katottg
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
    public function toArray(?LanguagesEnumInterface $language = null): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName()->getByLangOrArray($language),
          'katottg' => $this->getKatottg(),
          'koatuu' => $this->getKoatuu(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): RegionInterface
    {
        return new Region(
            id: (int) $entry['REGION_ID'],
            name: self::getMultilingualStringFromEntryAndKey($entry, 'REGION_#lang'),
            koatuu: (int) $entry['REGION_KOATUU'],
            katottg: (int) $entry['REGION_KATOTTG']
        );
    }

}
