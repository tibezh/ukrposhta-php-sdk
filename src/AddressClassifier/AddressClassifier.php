<?php

declare(strict_types=1);

namespace Ukrposhta\AddressClassifier;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Ukrposhta\AddressClassifier\Entities\Address\Address;
use Ukrposhta\AddressClassifier\Entities\Address\AddressCollection;
use Ukrposhta\AddressClassifier\Entities\Address\AddressCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\City\City;
use Ukrposhta\AddressClassifier\Entities\City\CityCollection;
use Ukrposhta\AddressClassifier\Entities\City\CityCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\City\CityInterface;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierArea;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierAreaInterface;
use Ukrposhta\AddressClassifier\Entities\District\District;
use Ukrposhta\AddressClassifier\Entities\District\DistrictCollection;
use Ukrposhta\AddressClassifier\Entities\District\DistrictCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnum;
use Ukrposhta\AddressClassifier\Entities\LanguagesEnumInterface;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOffice;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollection;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOffice;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollection;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHours;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursCollection;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlement;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlementCollection;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlementCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Region\Region;
use Ukrposhta\AddressClassifier\Entities\Region\RegionCollection;
use Ukrposhta\AddressClassifier\Entities\Region\RegionCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Settlement\Settlement;
use Ukrposhta\AddressClassifier\Entities\Settlement\SettlementCollection;
use Ukrposhta\AddressClassifier\Entities\Settlement\SettlementCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Street\Street;
use Ukrposhta\AddressClassifier\Entities\Street\StreetCollection;
use Ukrposhta\AddressClassifier\Entities\Street\StreetCollectionInterface;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Ukrposhta;

/**
 *
 */
class AddressClassifier extends Ukrposhta implements AddressClassifierInterface {

    /** @var string Base endpoint to get address classifier information. */
    public const BASE_ENDPOINT = 'address-classifier-ws';

    /** @var string Access type that needs to get address classifier information. */
    public const CREDENTIALS_TYPE = 'bearerCounterparty';

    public const REGIONS_ENDPOINT = '/get_regions_by_region_ua';

    public const DISTRICTS_BY_REGION_ID = '/get_districts_by_region_id_and_district_ua';

    public const CITIES_BY_REGION_ID_AND_DISTRICT_ID = '/get_city_by_region_id_and_district_id_and_city_ua';

    public const STREETS_BY_REGION_ID_AND_DISTRICT_ID_AND_CITY_ID = '/get_street_by_region_id_and_district_id_and_city_id_and_street_ua';

    public const ADDR_HOUSE_BY_STREET_ID = '/get_addr_house_by_street_id';

    public const COURIER_AREA_BY_POST_INDEX = '/get_courierarea_by_postindex';

    public const POST_OFFICES_BY_POST_INDEX = '/get_postoffices_by_postindex';

    public const POST_OFFICES_BY_CITY_ID = '/get_postoffices_by_city_id';

    public const POST_OFFICES_OPEN_HOURS_BY_POST_INDEX = '/get_postoffices_openhours_by_postindex';

    public const POST_OFFICES_BY_GEOLOCATION = '/get_postoffices_by_geolocation';

    public const CITY_DETAILS_BY_POSTCODE = '/get_city_details_by_postcode';

    /**
     * Request object that uses in the class.
     *
     * @var RequestInterface|null
     */
    private ?RequestInterface $request = null;

    /**
     * Address Classifier access token that uses for requests.
     *
     * @var string|null
     */
    private ?string $accessToken = null;

    /**
     * {@inheritDoc}
     */
    public function __construct(
      string $bearerEcom = null,
      string $bearerStatusTracking = null,
      string $bearerCounterparty = null,
      bool $sandbox = false,
      LoggerInterface $logger = null,
      RequestInterface $request = null,
    )
    {
        parent::__construct(
          $bearerEcom,
          $bearerStatusTracking,
          $bearerCounterparty,
          $sandbox,
          $logger
        );

        // Prepare request object.
        if (null !== $request) {
          $this->setRequest($request);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function requestRegions(
      string $name,
      LanguagesEnumInterface $language = LanguagesEnum::UA
    ): RegionCollectionInterface
    {

      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::REGIONS_ENDPOINT,
        ["region_name{$language->requestSuffix()}" => $name]
      );
      $response = $response->getResponseData();

      $regionCollection = new RegionCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $region = new Region(
            id: (int) $entry['REGION_ID'],
            nameUa: $entry['REGION_UA'],
            nameEn: $entry['REGION_EN'],
            koatuu: (int) $entry['REGION_KOATUU'],
            katottg: (int) $entry['REGION_KATOTTG']
          );
          $regionCollection->add($region);
        }
      }
      return $regionCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestDistrictsByRegionId(
      int $regionId,
      ?string $nameUa = null
    ): DistrictCollectionInterface {

      $requestData = ['region_id' => $regionId];
      if ($nameUa) {
        $requestData['district_ua'] = $nameUa;
      }

      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::DISTRICTS_BY_REGION_ID,
        $requestData
      );
      $response = $response->getResponseData();

      $districtCollection = new DistrictCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $district = new District(
            id: (int) $entry['DISTRICT_ID'],
            nameUa: $entry['DISTRICT_UA'],
            nameEn: $entry['DISTRICT_EN'],
            koatuu: (int) $entry['DISTRICT_KOATUU'],
            katottg: (int) $entry['DISTRICT_KATOTTG']
          );
          $districtCollection->add($district);
        }
      }
      return $districtCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestCityByRegionIdAndDistrictId(
      int $regionId,
      int $districtId,
      ?string $nameUa = null
    ): CityCollectionInterface
    {
      $requestData = ['region_id' => $regionId, 'district_id' => $districtId];
      return $this->requestCity($requestData, $nameUa);
    }

    /**
     * {@inheritDoc}
     */
    public function requestCityByDistrictId(int $districtId, ?string $nameUa = null): CityCollectionInterface
    {
      $requestData = ['district_id' => $districtId];
      return $this->requestCity($requestData, $nameUa);
    }

    /**
     * {@inheritDoc}
     */
    public function requestCityByRegionId(int $regionId, ?string $nameUa = null): CityCollectionInterface
    {
      $requestData = ['region_id' => $regionId];
      return $this->requestCity($requestData, $nameUa);
    }

    /**
     * Helper function to request City.
     *
     * @param array<string|int, string|mixed> $requestData
     *   Assoc array of request data.
     * @param string|null $nameUa
     *   Name of the city on UA language, null to fetch all cities, null by default.
     *
     * @return CityCollectionInterface
     *   List of cities.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestCity(array $requestData, ?string $nameUa = null): CityCollectionInterface
    {
      if ($nameUa) {
        $requestData['city_ua'] = $nameUa;
      }
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::CITIES_BY_REGION_ID_AND_DISTRICT_ID,
        $requestData
      );
      $response = $response->getResponseData();

      $cityCollection = new CityCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $city = $this->convertCityEntryResponse($entry);
          $cityCollection->add($city);
        }
      }
      return $cityCollection;
    }

    /**
     * Helper function to converts City Entry response to the City object.
     *
     * @param array<string|int, string|mixed> $entry
     *   City Entry response to process.
     *
     * @return CityInterface
     *   City object from the response data.
     */
    protected function convertCityEntryResponse(array $entry): CityInterface
    {
      return new City(
        id: (int) $entry['CITY_ID'],
        nameUa: $entry['CITY_UA'],
        nameEn: $entry['CITY_EN'],
        typeUa: $entry['CITYTYPE_UA'],
        typeEn: $entry['CITYTYPE_EN'],
        shortTypeUa: $entry['SHORTCITYTYPE_UA'],
        shortTypeEn: $entry['SHORTCITYTYPE_EN'],
        katottg: (int) $entry['CITY_KATOTTG'],
        koatuu: (int) $entry['CITY_KOATUU'],
        longitude: (float) $entry['LONGITUDE'],
        latitude: (float) $entry['LATTITUDE'],
        population: (int) $entry['POPULATION']
      );
    }

    /**
     * {@inheritDoc}
     */
    public function requestStreetByRegionIdAndDistrictIdAndCityId(
      int $regionId,
      int $districtId,
      int $cityId,
      ?string $nameUa = null
    ): StreetCollectionInterface
    {
      $requestData = [
        'region_id' => $regionId,
        'district_id' => $districtId,
        'city_id' => $cityId,
      ];
      if ($nameUa) {
        $requestData['street_ua'] = $nameUa;
      }

      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::STREETS_BY_REGION_ID_AND_DISTRICT_ID_AND_CITY_ID,
        $requestData
      );
      $response = $response->getResponseData();

      $streetCollection = new StreetCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $street = new Street(
            id: (int) $entry['STREET_ID'],
            nameUa: $entry['STREET_UA'],
            nameEn: $entry['STREET_EN'],
            typeUa: $entry['STREETTYPE_UA'],
            typeEn: $entry['STREETTYPE_EN'],
            shortTypeUa: $entry['SHORTSTREETTYPE_UA'],
            shortTypeEn: $entry['SHORTSTREETTYPE_EN'],
          );
          $streetCollection->add($street);
        }
      }
      return $streetCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestAddressHouseByStreetId(
      int $streetId,
      ?string $houseNumber = null
    ): AddressCollectionInterface
    {
      $requestData = ['street_id' => $streetId];
      if ($houseNumber) {
        $requestData['housenumber'] = $houseNumber;
      }

      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::ADDR_HOUSE_BY_STREET_ID,
        $requestData
      );
      $response = $response->getResponseData();

      $addressCollection = new AddressCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $address = new Address(
            postCode: (int) $entry['POSTCODE'],
            houseNumber: $entry['HOUSENUMBER_UA']
          );
          $addressCollection->add($address);
        }
      }
      return $addressCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestCourierAreaByPostCode(int $postCode): CourierAreaInterface
    {
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::COURIER_AREA_BY_POST_INDEX,
        ['postindex' => $postCode]
      );
      $response = $response->getResponseData();
      return new CourierArea(!empty($response['Entries']['Entry'][0]['IS_COURIERAREA']));
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByPostCode(int $postCode): PostOfficeCollectionInterface
    {
      $requestData = ['pc' => $postCode];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByPostIndex(int $postIndex): PostOfficeCollectionInterface
    {
      $requestData = ['pi' => $postIndex];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByCityId(int $cityId): PostOfficeCollectionInterface
    {
      $requestData = ['poCityId' => $cityId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByDistrictId(int $districtId): PostOfficeCollectionInterface
    {
      $requestData = ['poDistrictId' => $districtId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByStreetId(int $streetId): PostOfficeCollectionInterface
    {
      $requestData = ['poStreetId' => $streetId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByRegionId(int $regionId): PostOfficeCollectionInterface
    {
      $requestData = ['poRegionId' => $regionId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaCityId(int $serviceAreaCityId): PostOfficeCollectionInterface
    {
      $requestData = ['pdCityId' => $serviceAreaCityId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaDistrictId(int $serviceAreaDistrictId): PostOfficeCollectionInterface
    {
      $requestData = ['pdDistrictId' => $serviceAreaDistrictId];
      return $this->requestPostOffices($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaRegionId(int $serviceAreaRegionId): PostOfficeCollectionInterface
    {
      $requestData = ['pdRegionId' => $serviceAreaRegionId];
      return $this->requestPostOffices($requestData);
    }

  /**
   * Helper function to request PostOffice.
   *
   * @param array<string|int, string|mixed> $requestData
   *   Assoc array of request data.
   *
   * @return PostOfficeCollectionInterface
   *   List of post offices.
   *
   * @throws GuzzleException
   * @throws InvalidResponseException
   * @throws RequestException
   */
    protected function requestPostOffices(array $requestData): PostOfficeCollectionInterface
    {
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::POST_OFFICES_BY_POST_INDEX,
        $requestData
      );
      $response = $response->getResponseData();

      $postOfficeCollection = new PostOfficeCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $postOffice = $this->convertPostOfficeEntryResponse($entry);
          $postOfficeCollection->add($postOffice);
        }
      }
      return $postOfficeCollection;
    }

    /**
     * Converts Post Office entry response into PostOffice object.
     *
     * @param array<string|int, string|mixed> $entry
     *   Post Office Entry response to process.
     *
     * @return PostOfficeInterface
     *   PostOffice object.
     */
    protected function convertPostOfficeEntryResponse(array $entry): PostOfficeInterface
    {
      return new PostOffice(
        id: (int) $entry['ID'],
        code: (int) $entry['PO_CODE'],
        name: $entry['PO_LONG'],
        shortName: $entry['PO_SHORT'],
        type: $entry['TYPE_LONG'],
        typeShort: $entry['TYPE_SHORT'],
        typeAcronym: $entry['TYPE_ACRONYM'],
        postIndex: (int) $entry['POSTCODE'],
        postCode: (int) $entry['POSTCODE'],
        merezaNumber: (int) $entry['MEREZA_NUMBER'],
        lockUa: $entry['POLOCK_UA'],
        lockEn: $entry['POLOCK_EN'],
        lockCode: (int) $entry['LOCK_CODE'],
        regionId: (int) $entry['POREGION_ID'],
        serviceAreaRegionId: (int) $entry['PDREGION_ID'],
        districtId: (int) $entry['PODISTRICT_ID'],
        serviceAreaDistrictId: (int) $entry['PDDISTRICT_ID'],
        cityId: (int) $entry['POCITY_ID'],
        cityType: $entry['CITYTYPE_UA'],
        serviceAreaCityId: (int) $entry['PDCITY_ID'],
        serviceAreaCityUa: $entry['PDCITY_UA'],
        serviceAreaCityEn: $entry['PDCITY_EN'],
        serviceAreaCityTypeUa: $entry['PDCITYTYPE_UA'],
        serviceAreaCityTypeEn: $entry['PDCITYTYPE_EN'],
        serviceAreaShortCityTypeUa: $entry['SHORTPDCITYTYPE_UA'],
        serviceAreaShortCityTypeEn: $entry['SHORTPDCITYTYPE_EN'] ?? null,
        streetId: (int) $entry['POSTREET_ID'],
        parentId: (int) $entry['PARENT_ID'],
        address: $entry['ADDRESS'],
        phone: $entry['PHONE'],
        longitude: (float) $entry['LONGITUDE'],
        latitude: (float) $entry['LATTITUDE'],
        isVpz: (bool) $entry['ISVPZ'],
        isAvailable: (bool) $entry['AVALIBLE'],
        mrtps: (int) $entry['MRTPS'],
        techIndex: (int) $entry['TECHINDEX'],
        isDeliveryPossible: $entry['IS_NODISTRICT'] == 0,
      );
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByCityId(int $cityId): PostOfficeSettlementCollectionInterface
    {
      $requestData = ['city_id' => $cityId];
      return $this->requestPostOfficeSettlements($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByDistrictId(int $districtId): PostOfficeSettlementCollectionInterface
    {
      $requestData = ['district_id' => $districtId];
      return $this->requestPostOfficeSettlements($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByRegionId(int $regionId): PostOfficeSettlementCollectionInterface
    {
        $requestData = ['region_id' => $regionId];
        return $this->requestPostOfficeSettlements($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByPostIndex(int $postIndex): PostOfficeSettlementCollectionInterface
    {
      $requestData = ['postindex' => $postIndex];
      return $this->requestPostOfficeSettlements($requestData);
    }

    /**
     * Helper function to request PostOfficeSettlement.
     *
     * @param array<string|int, string|mixed> $requestData
     *   Assoc array of request data.
     *
     * @return PostOfficeSettlementCollectionInterface
     *   List of post office settlements.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestPostOfficeSettlements(array $requestData): PostOfficeSettlementCollectionInterface
    {
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::POST_OFFICES_BY_CITY_ID,
        $requestData
      );
      $response = $response->getResponseData();

      $postOfficeSettlementCollection = new PostOfficeSettlementCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $postOfficeSettlement = $this->convertPostOfficeSettlementEntryResponse($entry);
          $postOfficeSettlementCollection->add($postOfficeSettlement);
        }
      }
      return $postOfficeSettlementCollection;
    }

    /**
     * Converts Post Office entry response into PostOfficeSettlement object.
     *
     * @param array<string|int, string|mixed> $entry
     *   Post Office Settlement Entry response to process.
     *
     * @return PostOfficeSettlement
     *   PostOfficeSettlement object.
     */
    protected function convertPostOfficeSettlementEntryResponse(array $entry): PostOfficeSettlement
    {
      return new PostOfficeSettlement(
        id: (int) $entry['ID'],
        name: $entry['PO_LONG'],
        shortName: $entry['PO_SHORT'],
        type: $entry['TYPE_LONG'],
        shortType: $entry['TYPE_SHORT'],
        typeAcronym: $entry['TYPE_ACRONYM'],
        parentId: (int) $entry['PARENT_ID'],
        cityId: (int) $entry['CITY_ID'],
        cityUa: $entry['CITY_UA'],
        cityEn: $entry['CITY_EN'],
        cityTypeUa: $entry['CITYTYPE_UA'],
        cityTypeEn: $entry['CITYTYPE_EN'],
        shortCityTypeUa: $entry['SHORTCITYTYPE_UA'],
        shortCityTypeEn: $entry['SHORTCITYTYPE_EN'] ?? null,
        postIndex: (int) $entry['POSTINDEX'],
        regionId: (int) $entry['REGION_ID'],
        regionUa: $entry['REGION_UA'],
        regionEn: $entry['REGION_EN'],
        districtId: (int) $entry['DISTRICT_ID'],
        districtUa: $entry['DISTRICT_UA'],
        districtEn: $entry['DISTRICT_EN'],
        streetUa: $entry['STREET_UA'],
        streetEn: $entry['STREET_EN'],
        streetTypeUa: $entry['STREETTYPE_UA'],
        streetTypeEn: $entry['STREETTYPE_EN'],
        houseNumber: $entry['HOUSENUMBER'],
        address: $entry['ADDRESS'],
        longitude: (float) $entry['LONGITUDE'],
        latitude: (float) $entry['LATTITUDE'],
        isCash: (bool) $entry['IS_CASH'],
        isDhl: (bool) $entry['IS_DHL'],
        isSmartbox: (bool) $entry['IS_SMARTBOX'],
        isUrgentPostalTransfers: (bool) $entry['PELPEREKAZY'],
        isFlagman: (bool) $entry['IS_FLAGMAN'],
        hasPostTerminal: (bool) $entry['POSTTERMINAL'],
        isAutomated: (bool) $entry['IS_AUTOMATED'],
        isSecurity: (bool) $entry['IS_SECURITY'],
        lockCode: (int) $entry['LOCK_CODE'],
        lockUa: $entry['LOCK_UA'],
        lockEn: $entry['LOCK_EN'],
        phone: $entry['PHONE'],
        isVpz: (bool) $entry['ISVPZ'],
        merezaNumber: (int) $entry['MEREZA_NUMBER'],
        techIndex: (int) $entry['TECHINDEX'],
      );
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeOpenHoursByPostCode(int $serviceAreaPostCode): PostOfficeOpenHoursCollectionInterface
    {
      $requestData = ['pc' => $serviceAreaPostCode];
      return $this->requestPostOfficeOpenHours($requestData);
    }

    /**
     * Helper function to request PostOfficeOpenHours.
     *
     * @param array<string|int, string|mixed> $requestData
     *   Assoc array of request data.
     *
     * @return PostOfficeOpenHoursCollectionInterface
     *   List of Post Office Open Hours.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestPostOfficeOpenHours(array $requestData): PostOfficeOpenHoursCollectionInterface
    {
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::POST_OFFICES_OPEN_HOURS_BY_POST_INDEX,
        $requestData
      );
      $response = $response->getResponseData();

      $postOfficeOpenHoursCollection = new PostOfficeOpenHoursCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $postOfficeOpenHours = $this->convertPostOfficeOpenHoursEntryResponse($entry);
          $postOfficeOpenHoursCollection->add($postOfficeOpenHours);
        }
      }
      return $postOfficeOpenHoursCollection;
    }

    /**
     * Converts Post Office Open Hours entry response into PostOfficeOpenHours object.
     *
     * @param array<string|int, string|mixed> $entry
     *   Post Office Open Hours response to process.
     *
     * @return PostOfficeOpenHoursInterface
     *   PostOfficeSettlement object.
     */
    protected function convertPostOfficeOpenHoursEntryResponse(array $entry): PostOfficeOpenHoursInterface
    {
      return new PostOfficeOpenHours(
        id: (int) $entry['id'],
        type: $entry['POSTOFFICE_TYPE'],
        name: $entry['FULLNAME'],
        shortName: $entry['SHORTNAME'],
        lockReason: $entry['LOCK_REASON'],
        dayOfWeekNumber: (int) $entry['DAYOFWEEK_NUM'],
        dayOfWeekUa: $entry['DAYOFWEEK_UA'],
        dayOfWeekEn: $entry['DAYOFWEEK_EN'],
        shortDayOfWeekUa: $entry['DAYOFWEEK_SHORTNAME_UA'],
        shortDayOfWeekEn: $entry['DAYOFWEEK_SHORTNAME_EN'] ?? null,
        intervalType: $entry['INTERVALTYPE'],
        parentPostOfficeId: (int) $entry['POSTOFFICE_PARENT'],
        openingTime: $entry['TFROM'],
        closingTime: $entry['TTO'],
        workComment: $entry['WORKCOMMENT']
      );
    }

    /**
     * {@inheritDoc}
     */
    public function requestNearestPostOffices(
      float $latitude,
      float $longitude,
      int $maxDistance
    ): NearestPostOfficeCollectionInterface
    {

      $requestData = [
        'lat' => $latitude,
        'long' => $longitude,
        'maxdistance' => $maxDistance,
      ];
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::POST_OFFICES_BY_GEOLOCATION,
        $requestData
      );
      $response = $response->getResponseData();

      $nearestPostOfficeCollection = new NearestPostOfficeCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $nearestPostOffice = new NearestPostOffice(
            id: (int) $entry['ID'],
            cityName: $entry['CITYNAME'],
            address: $entry['ADDRESS'],
            filialName: $entry['POSTFILIALNAME'],
            distance: (int) $entry['DISTANCE'],
          );
          $nearestPostOfficeCollection->add($nearestPostOffice);
        }
      }
      return $nearestPostOfficeCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestSettlementsByPostCode(
      int $postCode,
      LanguagesEnumInterface $language = LanguagesEnum::UA
    ): SettlementCollectionInterface
    {
      $requestData = [
        'postcode' => $postCode,
        'lang' => $language->value,
      ];
      $response = $this->getRequest()->request(
        $this->getAccessToken(),
        'GET',
        $this->getEndpointUrl() . self::CITY_DETAILS_BY_POSTCODE,
        $requestData
      );
      $response = $response->getResponseData();

      $settlementCollection = new SettlementCollection();
      if (!empty($response['Entries']['Entry'])) {
        foreach ($response['Entries']['Entry'] as $entry) {
          $settlement = new Settlement(
            postCode: (int) $entry['POSTCODE'],
            regionId: (int) $entry['REGION_ID'],
            regionName: $entry['REGION_NAME'],
            districtId: (int) $entry['DISTRICT_ID'],
            districtName: $entry['DISTRICT_NAME'],
            cityId: (int) $entry['CITY_ID'],
            cityName: $entry['CITY_NAME'],
            cityTypeName: $entry['CITYTYPE_NAME'] ?? null,
            language: $language
          );
          $settlementCollection->add($settlement);
        }
      }
      return $settlementCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function getEndpointUrl(): string
    {
      return self::BASE_URL . self::BASE_ENDPOINT;
    }

    /**
     * Retrieves the request object.
     *
     * @return RequestInterface
     *   The request object.
     */
    public function getRequest(): RequestInterface
    {
      if (null === $this->request) {
        $this->request = new Request($this->getLogger());
      }

      return $this->request;
    }

    /**
     * Applies request object.
     *
     * @return $this
     */
    public function setRequest(RequestInterface $request): static
    {
      $this->request = $request;

      return $this;
    }

    /**
     * Applies Counterparty access token.
     *
     * @return $this
     */
    public function setAccessToken(string $bearerCounterpartyAccessToken): static
    {
      $this->accessToken = $bearerCounterpartyAccessToken;

      return $this;
    }

    /**
     * Gets Counterparty access token.
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
      if (!$this->accessToken) {
        if (!$this->{static::CREDENTIALS_TYPE}) {
          throw new NoCredentialException(sprintf('The %s token is required.', static::CREDENTIALS_TYPE));
        } else {
          $this->setAccessToken($this->{static::CREDENTIALS_TYPE});
        }
      }
      // todo: fix phpstan error with return type.
      /** @phpstan-ignore-next-line */
      return $this->accessToken;
    }

}
