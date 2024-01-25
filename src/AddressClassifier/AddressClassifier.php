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
use Ukrposhta\AddressClassifier\Entities\CitySearchItem\CitySearchItem;
use Ukrposhta\AddressClassifier\Entities\CitySearchItem\CitySearchItemCollection;
use Ukrposhta\AddressClassifier\Entities\CitySearchItem\CitySearchItemCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierArea;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierAreaInterface;
use Ukrposhta\AddressClassifier\Entities\DeliveryArea\DeliveryArea;
use Ukrposhta\AddressClassifier\Entities\DeliveryArea\DeliveryAreaCollection;
use Ukrposhta\AddressClassifier\Entities\DeliveryArea\DeliveryAreaCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\District\District;
use Ukrposhta\AddressClassifier\Entities\District\DistrictCollection;
use Ukrposhta\AddressClassifier\Entities\District\DistrictCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\DistrictSearchItem\DistrictSearchItem;
use Ukrposhta\AddressClassifier\Entities\DistrictSearchItem\DistrictSearchItemCollection;
use Ukrposhta\AddressClassifier\Entities\DistrictSearchItem\DistrictSearchItemCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\House\House;
use Ukrposhta\AddressClassifier\Entities\House\HouseCollection;
use Ukrposhta\AddressClassifier\Entities\House\HouseCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOffice;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollection;
use Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOffice;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollection;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu\PostOfficeKoatuu;
use Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu\PostOfficeKoatuuCollection;
use Ukrposhta\AddressClassifier\Entities\PostOfficeKoatuu\PostOfficeKoatuuCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHours;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursCollection;
use Ukrposhta\AddressClassifier\Entities\PostOfficeOpenHours\PostOfficeOpenHoursCollectionInterface;
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
use Ukrposhta\AddressClassifier\Entities\StreetSearchItem\StreetSearchItem;
use Ukrposhta\AddressClassifier\Entities\StreetSearchItem\StreetSearchItemCollection;
use Ukrposhta\AddressClassifier\Entities\StreetSearchItem\StreetSearchItemCollectionInterface;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Ukrposhta;
use Ukrposhta\Utilities\Languages\LanguagesEnum;
use Ukrposhta\Utilities\Languages\LanguagesEnumInterface;

/**
 *
 */
class AddressClassifier extends Ukrposhta implements AddressClassifierInterface
{

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

    public const ADDRESS_DETAILS_BY_POSTCODE = '/get_address_by_postcode';

    public const POSTCODE_BY_CITY_ID = '/get_postcode_by_city_id';

    public const POST_OFFICES_BY_KOATUU = '/get_postoffices_by_postcode_cityid_cityvpzid';

    public const DISTRICT_BY_NAME = '/get_district_by_name';

    public const CITY_BY_NAME = '/get_city_by_name';

    public const STREET_BY_NAME = '/get_street_by_name';

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
        array $options = [],
        LoggerInterface $logger = null,
        RequestInterface $request = null,
    ) {
        parent::__construct(
            $bearerEcom,
            $bearerStatusTracking,
            $bearerCounterparty,
            $sandbox,
            $options,
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
    ): RegionCollectionInterface {
        $requestParams = ["region_name{$language->requestSuffix()}" => $name];
        $response = $this->getResponseData(
            self::REGIONS_ENDPOINT,
            $requestParams
        );

        $regionCollection = new RegionCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $region = Region::fromResponseEntry($entry);
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
        $requestParams = ['region_id' => $regionId];
        if ($nameUa) {
            $requestParams['district_ua'] = $nameUa;
        }

        $response = $this->getResponseData(self::DISTRICTS_BY_REGION_ID, $requestParams);

        $districtCollection = new DistrictCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $district = District::fromResponseEntry($entry);
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
    ): CityCollectionInterface {
        $requestParams = ['region_id' => $regionId, 'district_id' => $districtId];
        return $this->requestCity($requestParams, $nameUa);
    }

    /**
     * {@inheritDoc}
     */
    public function requestCityByDistrictId(int $districtId, ?string $nameUa = null): CityCollectionInterface
    {
        $requestParams = ['district_id' => $districtId];
        return $this->requestCity($requestParams, $nameUa);
    }

    /**
     * {@inheritDoc}
     */
    public function requestCityByRegionId(int $regionId, ?string $nameUa = null): CityCollectionInterface
    {
        $requestParams = ['region_id' => $regionId];
        return $this->requestCity($requestParams, $nameUa);
    }

    /**
     * Helper function to request City.
     *
     * @param array<string|int, string|mixed> $requestParams
     *   Assoc array of request parameters.
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
    protected function requestCity(array $requestParams, ?string $nameUa = null): CityCollectionInterface
    {
        if ($nameUa) {
            $requestParams['city_ua'] = $nameUa;
        }
        $response = $this->getResponseData(self::CITIES_BY_REGION_ID_AND_DISTRICT_ID, $requestParams);

        $cityCollection = new CityCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $city = City::fromResponseEntry($entry);
                $cityCollection->add($city);
            }
        }
        return $cityCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestStreetByRegionIdAndDistrictIdAndCityId(
        int $regionId,
        int $districtId,
        int $cityId,
        ?string $nameUa = null
    ): StreetCollectionInterface {
        $requestParams = [
          'region_id' => $regionId,
          'district_id' => $districtId,
          'city_id' => $cityId,
        ];
        if ($nameUa) {
            $requestParams['street_ua'] = $nameUa;
        }

        $response = $this->getResponseData(
            self::STREETS_BY_REGION_ID_AND_DISTRICT_ID_AND_CITY_ID,
            $requestParams
        );

        $streetCollection = new StreetCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $street = Street::fromResponseEntry($entry);
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
    ): HouseCollectionInterface {
        $requestParams = ['street_id' => $streetId];
        if ($houseNumber) {
            $requestParams['housenumber'] = $houseNumber;
        }
        $response = $this->getResponseData(self::ADDR_HOUSE_BY_STREET_ID, $requestParams);

        $houseCollection = new HouseCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $house = House::fromResponseEntry($entry);
                $houseCollection->add($house);
            }
        }
        return $houseCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestCourierAreaByPostCode(int $postCode): CourierAreaInterface
    {
        $requestParams = ['postindex' => $postCode];
        $response = $this->getResponseData(self::COURIER_AREA_BY_POST_INDEX, $requestParams);
        return new CourierArea(!empty($response['Entries']['Entry'][0]['IS_COURIERAREA']));
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByPostCode(int $postCode): PostOfficeCollectionInterface
    {
        $requestParams = ['pc' => $postCode];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByPostIndex(int $postIndex): PostOfficeCollectionInterface
    {
        $requestParams = ['pi' => $postIndex];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByCityId(int $cityId): PostOfficeCollectionInterface
    {
        $requestParams = ['poCityId' => $cityId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByDistrictId(int $districtId): PostOfficeCollectionInterface
    {
        $requestParams = ['poDistrictId' => $districtId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByStreetId(int $streetId): PostOfficeCollectionInterface
    {
        $requestParams = ['poStreetId' => $streetId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByRegionId(int $regionId): PostOfficeCollectionInterface
    {
        $requestParams = ['poRegionId' => $regionId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaCityId(int $serviceAreaCityId): PostOfficeCollectionInterface
    {
        $requestParams = ['pdCityId' => $serviceAreaCityId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaDistrictId(int $serviceAreaDistrictId): PostOfficeCollectionInterface
    {
        $requestParams = ['pdDistrictId' => $serviceAreaDistrictId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeByServiceAreaRegionId(int $serviceAreaRegionId): PostOfficeCollectionInterface
    {
        $requestParams = ['pdRegionId' => $serviceAreaRegionId];
        return $this->requestPostOffices($requestParams);
    }

    /**
     * Helper function to request PostOffice.
     *
     * @param array<string|int, string|mixed> $requestParams
     *   Assoc array of request parameters.
     *
     * @return PostOfficeCollectionInterface
     *   List of post offices.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestPostOffices(array $requestParams): PostOfficeCollectionInterface
    {
        $response = $this->getResponseData(self::POST_OFFICES_BY_POST_INDEX, $requestParams);

        $postOfficeCollection = new PostOfficeCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $postOffice = PostOffice::fromResponseEntry($entry);
                $postOfficeCollection->add($postOffice);
            }
        }
        return $postOfficeCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByCityId(int $cityId): PostOfficeSettlementCollectionInterface
    {
        $requestParams = ['city_id' => $cityId];
        return $this->requestPostOfficeSettlements($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByDistrictId(int $districtId): PostOfficeSettlementCollectionInterface
    {
        $requestParams = ['district_id' => $districtId];
        return $this->requestPostOfficeSettlements($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByRegionId(int $regionId): PostOfficeSettlementCollectionInterface
    {
        $requestParams = ['region_id' => $regionId];
        return $this->requestPostOfficeSettlements($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeSettlementsByPostIndex(int $postIndex): PostOfficeSettlementCollectionInterface
    {
        $requestParams = ['postindex' => $postIndex];
        return $this->requestPostOfficeSettlements($requestParams);
    }

    /**
     * Helper function to request PostOfficeSettlement.
     *
     * @param array<string|int, string|mixed> $requestParams
     *   Assoc array of request parameters.
     *
     * @return PostOfficeSettlementCollectionInterface
     *   List of post office settlements.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestPostOfficeSettlements(array $requestParams): PostOfficeSettlementCollectionInterface
    {
        $response = $this->getResponseData(self::POST_OFFICES_BY_CITY_ID, $requestParams);

        $postOfficeSettlementCollection = new PostOfficeSettlementCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $postOfficeSettlement = PostOfficeSettlement::fromResponseEntry($entry);
                $postOfficeSettlementCollection->add($postOfficeSettlement);
            }
        }
        return $postOfficeSettlementCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeOpenHoursByPostCode(int $serviceAreaPostCode): PostOfficeOpenHoursCollectionInterface
    {
        $requestParams = ['pc' => $serviceAreaPostCode];
        $response = $this->getResponseData(self::POST_OFFICES_OPEN_HOURS_BY_POST_INDEX, $requestParams);

        $postOfficeOpenHoursCollection = new PostOfficeOpenHoursCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $postOfficeOpenHours = PostOfficeOpenHours::fromResponseEntry($entry);
                $postOfficeOpenHoursCollection->add($postOfficeOpenHours);
            }
        }
        return $postOfficeOpenHoursCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestNearestPostOffices(
        float $latitude,
        float $longitude,
        int $maxDistance
    ): NearestPostOfficeCollectionInterface {
        $requestParams = [
          'lat' => $latitude,
          'long' => $longitude,
          'maxdistance' => $maxDistance,
        ];
        $response = $this->getResponseData(self::POST_OFFICES_BY_GEOLOCATION, $requestParams);

        $nearestPostOfficeCollection = new NearestPostOfficeCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $nearestPostOffice = NearestPostOffice::fromResponseEntry($entry);
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
    ): SettlementCollectionInterface {
        $requestParams = [
          'postcode' => $postCode,
          'lang' => $language->value,
        ];
        $response = $this->getResponseData(self::CITY_DETAILS_BY_POSTCODE, $requestParams);

        $settlementCollection = new SettlementCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $settlement = Settlement::fromResponseEntry($entry);
                $settlementCollection->add($settlement);
            }
        }
        return $settlementCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestAddressesByPostCode(
        int $postCode,
        LanguagesEnumInterface $language = LanguagesEnum::UA
    ): AddressCollectionInterface {
        $requestParams = [
          'postcode' => $postCode,
          'lang' => $language->value,
        ];
        $response = $this->getResponseData(self::ADDRESS_DETAILS_BY_POSTCODE, $requestParams);

        $addressCollection = new AddressCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $address = Address::fromResponseEntry($entry);
                $addressCollection->add($address);
            }
        }
        return $addressCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestAreaDeliveryByCityId(int $cityId): DeliveryAreaCollectionInterface
    {
        $requestParams = ['city_id' => $cityId];
        $response = $this->getResponseData(self::POSTCODE_BY_CITY_ID, $requestParams);

        $deliveryAreaCollection = new DeliveryAreaCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $deliveryArea = DeliveryArea::fromResponseEntry($entry);
                $deliveryAreaCollection->add($deliveryArea);
            }
        }
        return $deliveryAreaCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeKoatuuByCityKoatuu(int $cityKoatuu): PostOfficeKoatuuCollectionInterface
    {
        $requestParams = ['city_koatuu' => $cityKoatuu];
        return $this->requestPostOfficeKoatuu($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeKoatuuByCityKatottg(int $cityKatottg): PostOfficeKoatuuCollectionInterface
    {
        $requestParams = ['city_katottg' => $cityKatottg];
        return $this->requestPostOfficeKoatuu($requestParams);
    }

    /**
     * {@inheritDoc}
     */
    public function requestPostOfficeKoatuuByCityVpzKatottg(int $cityVpzKatottg): PostOfficeKoatuuCollectionInterface
    {
        $requestParams = ['city_vpz_katottg' => $cityVpzKatottg];
        return $this->requestPostOfficeKoatuu($requestParams);
    }

    /**
     * Helper function to request Post Office Koatuu.
     *
     * @param array<string|int, string|mixed> $requestParams
     *   Assoc array of request parameters.
     *
     * @return PostOfficeKoatuuCollectionInterface
     *   The Post Office Koatuu collection object.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    protected function requestPostOfficeKoatuu(array $requestParams): PostOfficeKoatuuCollectionInterface
    {
        $response = $this->getResponseData(self::POST_OFFICES_BY_KOATUU, $requestParams);
        $postOfficeKoatuuCollection = new PostOfficeKoatuuCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $postOfficeKoatuu = PostOfficeKoatuu::fromResponseEntry($entry);
                $postOfficeKoatuuCollection->add($postOfficeKoatuu);
            }
        }
        return $postOfficeKoatuuCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestSearchDistrict(
        int $regionId,
        string $districtName,
        LanguagesEnumInterface $language = LanguagesEnum::UA,
        bool $fuzzy = true
    ): DistrictSearchItemCollectionInterface {
        $requestParams = [
          'region_id' => $regionId,
          'district_name' => $districtName,
          'lang' => $language->value,
          'fuzzy' => $fuzzy ? 1 : 0,
        ];
        $response = $this->getResponseData(self::DISTRICT_BY_NAME, $requestParams);
        $districtSearchItemCollection = new DistrictSearchItemCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $districtSearchItem = DistrictSearchItem::fromResponseEntry($entry);
                $districtSearchItemCollection->add($districtSearchItem);
            }
        }
        return $districtSearchItemCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestSearchCity(
        int $regionId,
        int $districtId,
        string $cityName,
        LanguagesEnumInterface $language = LanguagesEnum::UA,
        bool $fuzzy = true
    ): CitySearchItemCollectionInterface {
        $requestParams = [
          'region_id' => $regionId,
          'district_id' => $districtId,
          'city_name' => $cityName,
          'lang' => $language->value,
          'fuzzy' => $fuzzy ? 1 : 0,
        ];
        $response = $this->getResponseData(self::CITY_BY_NAME, $requestParams);
        $citySearchItemCollection = new CitySearchItemCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $citySearchItem = CitySearchItem::fromResponseEntry($entry);
                $citySearchItemCollection->add($citySearchItem);
            }
        }
        return $citySearchItemCollection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestSearchStreet(
        int $cityId,
        string $streetName,
        LanguagesEnumInterface $language = LanguagesEnum::UA,
        bool $fuzzy = true
    ): StreetSearchItemCollectionInterface {
        $requestParams = [
          'city_id' => $cityId,
          'street_name' => $streetName,
          'lang' => $language->value,
          'fuzzy' => $fuzzy ? 1 : 0,
        ];
        $response = $this->getResponseData(self::STREET_BY_NAME, $requestParams);
        $streetSearchItemCollection = new StreetSearchItemCollection();
        if (!empty($response['Entries']['Entry'])) {
            foreach ($response['Entries']['Entry'] as $entry) {
                $streetSearchItem = StreetSearchItem::fromResponseEntry($entry);
                $streetSearchItemCollection->add($streetSearchItem);
            }
        }
        return $streetSearchItemCollection;
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

    /**
     * Helper function to make request.
     *
     * @param string $endpoint
     *   The endpoint of the request.
     * @param array<string, mixed> $requestParams
     *   An associative array that contains parameters for a request.
     *
     * @return array<string|int, string|mixed|array<string, mixed>>
     *   Response data.
     *
     * @throws GuzzleException
     * @throws InvalidResponseException
     * @throws RequestException
     */
    public function getResponseData(string $endpoint, array $requestParams = []): array
    {
        $response = $this->getRequest()->request(
            $this->getAccessToken(),
            'GET',
            $this->getEndpointUrl() . $endpoint,
            $requestParams
        );
        return $response->getResponseData();
    }

}
