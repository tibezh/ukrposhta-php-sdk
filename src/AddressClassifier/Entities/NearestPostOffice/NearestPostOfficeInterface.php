<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\NearestPostOffice;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 *
 */
interface NearestPostOfficeInterface extends EntityInterface
{

    /**
     * Gets Nearest Post Office ID.
     *
     * @return int
     *   Nearest Post Office unique identifier.
     */
    public function getId(): int;

    /**
     * Gets city name.
     *
     * @return string
     *   City name of the Nearest Post Office.
     */
    public function getCityName(): string;

    /**
     * Gets address.
     *
     * @return string
     *   Address of the Nearest Post Office.
     */
    public function getAddress(): string;

    /**
     * Gets filial name.
     *
     * @return string
     *   Filial name of the Nearest Post Office.
     */
    public function getFilialName(): string;

    /**
     * Gets distance.
     *
     * @return int
     *   Distance in kilometers to the Nearest Post Office.
     */
    public function getDistance(): int;

    /**
     * Gets an associative array version of the Nearest Post Office.
     *
     * @return array<string, mixed>
     *    Array version of the object.
     */
    public function toArray(): array;

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): NearestPostOfficeInterface;

}
