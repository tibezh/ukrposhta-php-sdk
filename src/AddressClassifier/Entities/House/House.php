<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\House;

/**
 * House entity.
 */
class House implements HouseInterface
{

    /**
     * House constructor.
     *
     * @param int $postCode
     *   Post code value.
     * @param string $houseNumber
     *   House number value.
     */
    public function __construct(
        protected readonly int $postCode,
        protected readonly string $houseNumber
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getPostCode(): int
    {
        return $this->postCode;
    }

    /**
     * {@inheritDoc}
     */
    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
          'postcode' => $this->getPostCode(),
          'house_number' => $this->getHouseNumber(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): HouseInterface
    {
        return new House(
            postCode: (int) $entry['POSTCODE'],
            houseNumber: $entry['HOUSENUMBER_UA']
        );
    }

}
