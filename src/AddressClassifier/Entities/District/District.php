<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\District;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class District implements DistrictInterface
{

    use StringMultilingualTrait;

    /**
     * District constructor.
     *
     * @param int $id
     *   District ID.
     * @param StringMultilingualInterface $name
     *   Region name.
     * @param int $koatuu
     *   District KOATUU code.
     * @param int $katottg
     *   District KATOTTG code.
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
    public function getKoatuu(): int
    {
        return $this->koatuu;
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
    public function toArray(?LanguagesEnumInterface $language = null): array
    {
        return [
          'id' => $this->getId(),
          'name' => $this->getName()->getByLangOrArray($language),
          'koatuu' => $this->getKoatuu(),
          'katottg' => $this->getKatottg(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): DistrictInterface
    {
        return new District(
            id: (int) $entry['DISTRICT_ID'],
            name: self::getMultilingualStringFromEntryAndKey($entry, 'DISTRICT_#lang'),
            koatuu: (int) $entry['DISTRICT_KOATUU'],
            katottg: (int) $entry['DISTRICT_KATOTTG']
        );
    }

}
