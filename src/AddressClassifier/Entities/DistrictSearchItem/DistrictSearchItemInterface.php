<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\DistrictSearchItem;

use Ukrposhta\AddressClassifier\Entities\EntityInterface;

/**
 *
 */
interface DistrictSearchItemInterface extends EntityInterface
{

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getRegionId(): int;

    /**
     * @return string
     */
    public function getRegionName(): string;

    /**
     * @return array<string, mixed>
     *   Array version of the object.
     */
    public function toArray(): array;

}
