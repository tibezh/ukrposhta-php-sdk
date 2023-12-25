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
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOffice;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollection;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeInterface;
use Ukrposhta\AddressClassifier\Entities\Region\Region;
use Ukrposhta\AddressClassifier\Entities\Region\RegionCollection;
use Ukrposhta\AddressClassifier\Entities\Region\RegionCollectionInterface;
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
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByPostIndex(int $postIndex): PostOfficeCollectionInterface
    {
      $requestData = ['pi' => $postIndex];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByCityId(int $cityId): PostOfficeCollectionInterface
    {
      $requestData = ['poCityId' => $cityId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByDistrictId(int $districtId): PostOfficeCollectionInterface
    {
      $requestData = ['poDistrictId' => $districtId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByStreetId(int $streetId): PostOfficeCollectionInterface
    {
      $requestData = ['poStreetId' => $streetId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByRegionId(int $regionId): PostOfficeCollectionInterface
    {
      $requestData = ['poRegionId' => $regionId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByAdditionalCityId(int $additionalCityId): PostOfficeCollectionInterface
    {
      $requestData = ['pdCityId' => $additionalCityId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByAdditionalDistrictId(int $additionalDistrictId): PostOfficeCollectionInterface
    {
      $requestData = ['pdDistrictId' => $additionalDistrictId];
      return $this->requestPostOffice($requestData);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByAdditionalRegionId(int $additionalRegionId): PostOfficeCollectionInterface
    {
      $requestData = ['pdRegionId' => $additionalRegionId];
      return $this->requestPostOffice($requestData);
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
    protected function requestPostOffice(array $requestData): PostOfficeCollectionInterface
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
   * @param array<string|int, string|mixed> $entry
   *   City Entry response to process.
   *
   * @return PostOfficeInterface
   */
    protected function convertPostOfficeEntryResponse(array $entry): PostOfficeInterface
    {
      return new PostOffice(
        id: (int) $entry['ID'],
        code: (int) $entry['PO_CODE'],
        name: $entry['PO_LONG'],
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
        districtId: (int) $entry['PODISTRICT_ID'],
        cityId: (int) $entry['POCITY_ID'],
        cityType: $entry['CITYTYPE_UA'],
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
      );
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
