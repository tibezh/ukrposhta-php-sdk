<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier\Entities\NearestPostOffice;

/**
 *
 */
interface NearestPostOfficeInterface
{

  /**
   * Gets Post Office ID.
   *
   * @return int
   *   Post Office unique identifier.
   */
  public function getId(): int;

  /**
   * Gets city name.
   *
   * @return string
   *   City name of the Post Office.
   */
  public function getCityName(): string;

  /**
   * Gets address.
   *
   * @return string
   *   Address of the Post Office.
   */
  public function getAddress(): string;

  /**
   * Gets filial name.
   *
   * @return string
   *   Filial name of the Post Office.
   */
  public function getFilialName(): string;

  /**
   * Gets distance.
   *
   * @return int
   *   Distance in kilometers to the Post Office.
   */
  public function getDistance(): int;

}
