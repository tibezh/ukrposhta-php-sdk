<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Street;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;
use Ukrposhta\Utilities\Languages\StringMultilingualInterface;

/**
 * Provides required methods for Street entity.
 */
interface StreetInterface extends EntityInterface
{

    /**
     * Gets street ID.
     *
     * @return int
     *   ID of the street.
     */
    public function getId(): int;

    /**
     * Gets street name.
     *
     * @return StringMultilingualInterface
     *   Name of the street.
     */
    public function getName(): StringMultilingualInterface;

    /**
     * Gets street type.
     *
     * @return StringMultilingualInterface
     *   Type of the street.
     */
    public function getType(): StringMultilingualInterface;

    /**
     * Gets street short type.
     *
     * @return StringMultilingualInterface
     *   Short type of the street, can be null for specific languages.
     */
    public function getShortType(): StringMultilingualInterface;

    /**
     * Gets an associative array version of the Street.
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
    public static function fromResponseEntry(array $entry): StreetInterface;

}
