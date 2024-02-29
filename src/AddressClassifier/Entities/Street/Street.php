<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualTrait;

/**
 *
 */
class Street implements StreetInterface
{

    use StringMultilingualTrait;

    /**
     * Street constructor.
     *
     * @param int $id
     *   Street ID.
     * @param StringMultilingualInterface $name
     * @param StringMultilingualInterface $type
     * @param StringMultilingualInterface $shortType
     */
    public function __construct(
        protected readonly int $id,
        protected readonly StringMultilingualInterface $name,
        protected readonly StringMultilingualInterface $type,
        protected readonly StringMultilingualInterface $shortType,
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
    public function getShortType(): StringMultilingualInterface
    {
        return $this->shortType;
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
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): StreetInterface
    {
        return new Street(
            id: (int) $entry['STREET_ID'],
            name: self::getMultilingualStringFromEntryAndKey($entry, 'STREET_#lang'),
            type: self::getMultilingualStringFromEntryAndKey($entry, 'STREETTYPE_#lang'),
            shortType: self::getMultilingualStringFromEntryAndKey($entry, 'SHORTSTREETTYPE_#lang'),
        );
    }

}
