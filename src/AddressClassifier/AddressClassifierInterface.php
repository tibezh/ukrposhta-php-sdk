<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier;

use Ukrposhta\AddressClassifier\Entities\Address\AddressCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\City\CityCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierAreaInterface;
use Ukrposhta\AddressClassifier\Entities\District\DistrictCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlementCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Region\RegionCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Settlement\SettlementCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Street\StreetCollectionInterface;

/**
 *
 */
interface AddressClassifierInterface {

  /**
   * Requests regions.
   *
   * @param string $name
   *   Name of the region.
   * @param LanguagesEnumInterface $language
   *   Language of the region name, LanguagesEnum::UA by default.
   *
   * @return RegionCollectionInterface
   *   List of matched regions.
   */
  public function requestRegions(
    string $name,
    LanguagesEnumInterface $language = LanguagesEnum::UA
  ): RegionCollectionInterface;

  /**
   * Requests districts by Region ID.
   *
   * @param int $regionId
   *   ID of the region that related district.
   * @param string|null $nameUa
   *   Name of the district on UA language, null to fetch all districts, null by default.
   *
   * @return DistrictCollectionInterface
   *   List of the districts.
   */
  public function requestDistrictsByRegionId(int $regionId, ?string $nameUa = null): DistrictCollectionInterface;

  /**
   * Request cities by Region ID and District ID.
   *
   * @param int $regionId
   *   ID of the region that related to City.
   * @param int $districtId
   *   ID of the district that related to City.
   * @param string|null $nameUa
   *   Name of the city on UA language, null to fetch all cities, null by default.
   *
   * @return CityCollectionInterface
   *   List of cities.
   */
  public function requestCityByRegionIdAndDistrictId(
    int $regionId,
    int $districtId,
    ?string $nameUa = null
  ): CityCollectionInterface;

  /**
   * Request cities by District ID.
   *
   * @param int $districtId
   *   ID of the district that related to City.
   * @param string|null $nameUa
   *   Name of the city on UA language, null to fetch all cities, null by default.
   *
   * @return CityCollectionInterface
   *   List of cities.
   */
  public function requestCityByDistrictId(int $districtId, ?string $nameUa = null): CityCollectionInterface;

  /**
   * Request cities by Region ID.
   *
   * @param int $regionId
   *   ID of the region that related to City.
   * @param string|null $nameUa
   *   Name of the city on UA language, null to fetch all cities, null by default.
   *
   * @return CityCollectionInterface
   *   List of cities.
   */
  public function requestCityByRegionId(int $regionId, ?string $nameUa = null): CityCollectionInterface;

  /**
   * Requests street by region, district and city ID.
   *
   * @param int $regionId
   *   ID of the region that related to Street.
   * @param int $districtId
   *   ID of the district that related to Street.
   * @param int $cityId
   *   ID of the city that related to Street.
   * @param string|null $nameUa
   *   Name of the street on UA language, null to fetch all cities, null by default.
   *
   * @return StreetCollectionInterface
   *   List of streets.
   */
  public function requestStreetByRegionIdAndDistrictIdAndCityId(
    int $regionId,
    int $districtId,
    int $cityId,
    ?string $nameUa = null
  ): StreetCollectionInterface;

  /**
   * Requests address (post code) by Street ID and house number.
   *
   * @param int $streetId
   *   ID of the street that related to Address.
   * @param string|null $houseNumber
   *   Number of the house that related to Address.
   *
   * @return AddressCollectionInterface
   *   Address Collection object.
   */
  public function requestAddressHouseByStreetId(
    int $streetId,
    ?string $houseNumber = null
  ): AddressCollectionInterface;

  /**
   * Requests Courier Area information by Post Code.
   *
   * @param int $postCode
   *   Post Code for the request.
   *
   * @return CourierAreaInterface
   *   Courier Area object.
   */
  public function requestCourierAreaByPostCode(int $postCode): CourierAreaInterface;

  /**
   * Requests Post Offices by Post Code.
   *
   * @param int $postCode
   *   Post Code for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByPostCode(int $postCode): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by Post Index.
   *
   * @param int $postIndex
   *   Post index for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByPostIndex(int $postIndex): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by City ID.
   *
   * @param int $cityId
   *   City ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByCityId(int $cityId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by District ID.
   *
   * @param int $districtId
   *   District ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByDistrictId(int $districtId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by Street ID.
   *
   * @param int $streetId
   *   Street ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByStreetId(int $streetId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by Region ID.
   *
   * @param int $regionId
   *   Region ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByRegionId(int $regionId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by service area City ID.
   *
   * @param int $serviceAreaCityId
   *   Service area City ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByServiceAreaCityId(int $serviceAreaCityId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by service area District ID.
   *
   * @param int $serviceAreaDistrictId
   *   Service area District ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByServiceAreaDistrictId(int $serviceAreaDistrictId): PostOfficeCollectionInterface;

  /**
   * Requests Post Offices by service area Region ID.
   *
   * @param int $serviceAreaRegionId
   *   Service area Region ID for the request.
   *
   * @return PostOfficeCollectionInterface
   *   Post Offices Collection object.
   */
  public function requestPostOfficeByServiceAreaRegionId(int $serviceAreaRegionId): PostOfficeCollectionInterface;

  /**
   * Requests Post Office Settlements by City ID.
   *
   * @param int $cityId
   *   City ID for the request.
   *
   * @return PostOfficeSettlementCollectionInterface
   *   Post Office Settlement Collection object.
   */
  public function requestPostOfficeSettlementsByCityId(int $cityId): PostOfficeSettlementCollectionInterface;

  /**
   * Requests Post Office Settlements by District ID.
   *
   * @param int $districtId
   *   District ID for the request.
   *
   * @return PostOfficeSettlementCollectionInterface
   *   Post Office Settlement Collection object.
   */
  public function requestPostOfficeSettlementsByDistrictId(int $districtId): PostOfficeSettlementCollectionInterface;

  /**
   * Requests Post Office Settlements by Region ID.
   *
   * @param int $regionId
   *   Region ID for the request.
   *
   * @return PostOfficeSettlementCollectionInterface
   *   Post Office Settlement Collection object.
   */
  public function requestPostOfficeSettlementsByRegionId(int $regionId): PostOfficeSettlementCollectionInterface;

  /**
   * Requests Post Office Settlements by Post Index ID.
   *
   * @param int $postIndex
   *   Post Index ID for the request.
   *
   * @return PostOfficeSettlementCollectionInterface
   *   Post Office Settlement Collection object.
   */
  public function requestPostOfficeSettlementsByPostIndex(int $postIndex): PostOfficeSettlementCollectionInterface;

  /**
   * Requests Post Office Open Hours by service area post code.
   *
   * @param int $serviceAreaPostCode
   *   Service area post code.
   *
   * @return PostOfficeOpenHoursCollectionInterface
   *   Post Office Open Hours collection object.
   */
  public function requestPostOfficeOpenHoursByPostCode(int $serviceAreaPostCode): PostOfficeOpenHoursCollectionInterface;

  /**
   * Requests nearest Post Offices.
   *
   * @param float $latitude
   *   Latitude coordinate.
   * @param float $longitude
   *   Longitude coordinate.
   * @param int $maxDistance
   *   Radius of distance to search.
   *
   * @return NearestPostOfficeCollectionInterface
   *   Nearest Post Offices collection object.
   */
  public function requestNearestPostOffices(float $latitude, float $longitude, int $maxDistance): NearestPostOfficeCollectionInterface;

  /**
   * Request Settlements by post code.
   *
   * @param int $postCode
   *   Post code for the request.
   * @param LanguagesEnumInterface $language
   *   Language for the request, LanguagesEnum::UA by default.
   *
   * @return SettlementCollectionInterface
   *   Settlements collection object.
   */
  public function requestSettlementsByPostCode(int $postCode, LanguagesEnumInterface $language = LanguagesEnum::UA): SettlementCollectionInterface;

}
