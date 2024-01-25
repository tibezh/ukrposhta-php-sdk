<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\DeliveryArea;

/**
 *
 */
class DeliveryArea implements DeliveryAreaInterface
{

    public function __construct(
        protected readonly int $cityId,
        protected readonly int $postCode
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getCityId(): int
    {
        return $this->cityId;
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
    public function toArray(): array
    {
        return [
          'city_id' => $this->getCityId(),
          'postcode' => $this->getPostCode(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponseEntry(array $entry): DeliveryAreaInterface
    {
        return new DeliveryArea(
            cityId: (int) $entry['CITY_ID'],
            postCode: (int) $entry['POSTCODE']
        );
    }

}
