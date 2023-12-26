<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\Settlement;

use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;

/**
 *
 */
class Settlement implements SettlementInterface
{

  /**
   * Settlement contructor.
   *
   * @param int $postCode
   * @param int $regionId
   * @param string $regionName
   * @param int $districtId
   * @param string $districtName
   * @param int $cityId
   * @param string $cityName
   * @param string|null $cityTypeName
   * @param LanguagesEnumInterface $language
   */
  public function __construct(
    protected readonly int $postCode,
    protected readonly int $regionId,
    protected readonly string $regionName,
    protected readonly int $districtId,
    protected readonly string $districtName,
    protected readonly int $cityId,
    protected readonly string $cityName,
    protected readonly ?string $cityTypeName,
    protected readonly LanguagesEnumInterface $language
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
  public function getRegionId(): int
  {
    return $this->regionId;
  }

  /**
   * {@inheritDoc}
   */
  public function getRegionName(): string
  {
    return $this->regionName;
  }

  /**
   * {@inheritDoc}
   */
  public function getDistrictId(): int
  {
    return $this->districtId;
  }

  /**
   * {@inheritDoc}
   */
  public function getDistrictName(): string
  {
    return $this->districtName;
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
  public function getCityName(): ?string
  {
    return $this->cityName;
  }

  /**
   * {@inheritDoc}
   */
  public function getCityTypeName(): string
  {
    return $this->cityTypeName;
  }

  /**
   * {@inheritDoc}
   */
  public function getLanguage(): LanguagesEnumInterface
  {
    return $this->language;
  }

}
