<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Large;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Ukrposhta\AddressClassifier\AddressClassifier;
use Ukrposhta\AddressClassifier\Entities\City\CityCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\City\CityInterface;
use Ukrposhta\AddressClassifier\Entities\CourierArea\CourierAreaInterface;
use Ukrposhta\AddressClassifier\Entities\District\DistrictInterface;
use Ukrposhta\AddressClassifier\Entities\House\HouseCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\House\HouseInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeInterface;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlementCollection;
use Ukrposhta\AddressClassifier\Entities\PostOfficeSettlement\PostOfficeSettlementInterface;
use Ukrposhta\AddressClassifier\Entities\Region\RegionInterface;
use Ukrposhta\AddressClassifier\Entities\Street\StreetCollectionInterface;
use Ukrposhta\AddressClassifier\Entities\Street\StreetInterface;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Response\ResponseInterface;
use Ukrposhta\Utilities\Languages\LanguagesEnum;

#[CoversClass(AddressClassifier::class)]
#[Large]
class AddressClassifierTest extends TestCase
{

    private AddressClassifier $addressClassifier;
    private RequestInterface&MockObject $requestMock;
    private LoggerInterface&MockObject $loggerMock;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $this->requestMock = $this->createMock(RequestInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);

        $this->addressClassifier = new AddressClassifier(
            bearerCounterparty: 'testToken',
            logger: $this->loggerMock,
            request: $this->requestMock
        );
    }

    /**
     * Helper method to fetch mock response object.
     *
     * @param array<string|int, string|mixed|array<string, mixed>> $responseData
     *
     * @return ResponseInterface
     *   Anon class with provided response data.
     */
    private function getMockResponse(array $responseData): ResponseInterface
    {
        return new class($responseData) implements ResponseInterface {
            /** @phpstan-ignore-next-line */
            private array $response;
            /** @phpstan-ignore-next-line */
            public function __construct(array $response)
            {
                $this->response = $response;
            }
            public function getResponseData(): array
            {
                return $this->response;
            }
        };
    }

    public function testGetRequest(): void
    {
        // Test from object in the setUp method.
        $request = $this->addressClassifier->getRequest();
        $this->assertInstanceOf(RequestInterface::class, $request);

        // Test without provided request object.
        $addressClassifier = new AddressClassifier(
            bearerCounterparty: 'testToken',
            logger: $this->loggerMock,
        );
        $request = $addressClassifier->getRequest();
        $this->assertInstanceOf(RequestInterface::class, $request);
    }

    public function testGetAccessToken(): void
    {
        // Assuming AddressClassifier is set up in setUp().
        // Set an access token for testing.
        $expectedToken = 'testToken';
        $this->addressClassifier->setAccessToken($expectedToken);

        // Use Reflection to make getAccessToken method accessible.
        $reflection = new \ReflectionClass($this->addressClassifier);
        $method = $reflection->getMethod('getAccessToken');
        // Call the now accessible getAccessToken method.
        $accessToken = $method->invoke($this->addressClassifier);
        // Assert the protected getAccessToken method returns the correct token.
        $this->assertEquals($expectedToken, $accessToken);

        // Create a new AddressClassifier instance without setting an access token.
        $addressClassifier = new AddressClassifier(
            logger: $this->loggerMock,
            request: $this->requestMock
        );
        // Use Reflection to make getAccessToken method accessible.
        $reflection = new \ReflectionClass($addressClassifier);
        $method = $reflection->getMethod('getAccessToken');

        // Expect a NoCredentialException when calling getAccessToken with no token set.
        $this->expectException(NoCredentialException::class);
        // Call the now accessible getAccessToken method.
        $method->invoke($addressClassifier);
    }

    public function testRequestRegions(): void
    {
        $responseData = [
            'Entries' => [
                'Entry' => [
                    [
                        'REGION_ID' => '1',
                        'REGION_UA' => 'Test Region UA 1',
                        'REGION_EN' => 'Test Region EN 1',
                        'REGION_KOATUU' => '123',
                        'REGION_KATOTTG' => '321',
                    ],
                    [
                        'REGION_ID' => '2',
                        'REGION_UA' => 'Test Region UA 2',
                        'REGION_EN' => 'Test Region EN 2',
                        'REGION_KOATUU' => '321',
                        'REGION_KATOTTG' => '123',
                    ],
                ]
            ]
        ];

        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regions = $this->addressClassifier->requestRegions('Test');

        $this->assertNotEmpty($regions->all());
        $this->assertCount(2, $regions->all());

        foreach ($regions->all() as $key => $region) {
            $regionId = $key + 1;
            $this->assertInstanceOf(RegionInterface::class, $region);
            $this->assertEquals($regionId, $region->getId());
            $this->assertEquals("Test Region UA $regionId", $region->getName()->getByLanguage(LanguagesEnum::UA));
            $this->assertEquals("Test Region EN $regionId", $region->getName()->getByLanguage(LanguagesEnum::EN));
            $this->assertEquals($key === 0 ? 123 : 321, $region->getKoatuu());
            $this->assertEquals($key === 0 ? 321 : 123, $region->getKatottg());
        }
    }

    public function testRequestDistrictsByRegionId(): void
    {
        $responseData = [
            'Entries' => [
                'Entry' => [
                    [
                        'DISTRICT_ID' => '1',
                        'DISTRICT_UA' => 'District 1 UA',
                        'DISTRICT_EN' => 'District 1 EN',
                        'DISTRICT_KOATUU' => '123',
                        'DISTRICT_KATOTTG' => '321',
                    ],
                    [
                        'DISTRICT_ID' => '2',
                        'DISTRICT_UA' => 'District 2 UA',
                        'DISTRICT_EN' => 'District 2 EN',
                        'DISTRICT_KOATUU' => '321',
                        'DISTRICT_KATOTTG' => '123',
                    ],
                ],
            ],
        ];

        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $districts = $this->addressClassifier->requestDistrictsByRegionId(1, 'test');

        $this->assertNotEmpty($districts->all());
        $this->assertCount(2, $districts->all());

        foreach ($districts->all() as $key => $district) {
            $districtId = $key + 1;
            $this->assertInstanceOf(DistrictInterface::class, $district);
            $this->assertEquals($districtId, $district->getId());
            $this->assertEquals("District $districtId UA", $district->getName()->getByLanguage(LanguagesEnum::UA));
            $this->assertEquals("District $districtId EN", $district->getName()->getByLanguage(LanguagesEnum::EN));
            $this->assertEquals($key === 0 ? 123 : 321, $district->getKoatuu());
            $this->assertEquals($key === 0 ? 321 : 123, $district->getKatottg());
        }
    }

    /** @phpstan-ignore-next-line */
    private function getRequestCityResponseData(): array
    {
        return [
            'Entries' => [
                'Entry' => [
                    [
                        'CITY_ID' => '1',
                        'CITY_UA' => 'City 1 UA',
                        'CITY_EN' => 'City 1 EN',
                        'CITYTYPE_UA' => 'City 1 type UA',
                        'CITYTYPE_EN' => 'City 1 type EN',
                        'SHORTCITYTYPE_UA' => 'City 1 short type UA',
                        'SHORTCITYTYPE_EN' => 'City 1 short type EN',
                        'CITY_KATOTTG' => '2',
                        'CITY_KOATUU' => '3',
                        'LONGITUDE' => '1.123',
                        'LATTITUDE' => '2.123',
                        'POPULATION' => '112345',
                    ],
                    [
                        'CITY_ID' => '2',
                        'CITY_UA' => 'City 2 UA',
                        'CITY_EN' => 'City 2 EN',
                        'CITYTYPE_UA' => 'City 2 type UA',
                        'CITYTYPE_EN' => 'City 2 type EN',
                        'SHORTCITYTYPE_UA' => 'City 2 short type UA',
                        'SHORTCITYTYPE_EN' => 'City 2 short type EN',
                        'CITY_KATOTTG' => '3',
                        'CITY_KOATUU' => '4',
                        'LONGITUDE' => '2.123',
                        'LATTITUDE' => '3.123',
                        'POPULATION' => '212345',
                    ]
                ]
            ]
        ];
    }

    private function assertCityResponseData(CityInterface $city, int $cityId): void
    {
        $this->assertEquals("City {$cityId} UA", $city->getName()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("City {$cityId} EN", $city->getName()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals("City {$cityId} type UA", $city->getType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("City {$cityId} type EN", $city->getType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals("City {$cityId} short type UA", $city->getShortType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("City {$cityId} short type EN", $city->getShortType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals($cityId + 1, $city->getKatottg());
        $this->assertEquals($cityId + 2, $city->getKoatuu());
        $this->assertEquals((float) "$cityId.123", $city->getLongitude());
        $this->assertEquals((float) (($cityId + 1) . '.123'), $city->getLatitude());
        $this->assertEquals((int) "{$cityId}12345", $city->getPopulation());
    }

    public function testRequestCityByRegionIdAndDistrictId(): void
    {
        $responseData = $this->getRequestCityResponseData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regionId = 1;
        $districtId = 2;
        $nameUa = 'Name UA';
        $cityCollection = $this->addressClassifier->requestCityByRegionIdAndDistrictId($regionId, $districtId, $nameUa);

        // Base assertions.
        $this->assertInstanceOf(CityCollectionInterface::class, $cityCollection);
        $cities = $cityCollection->all();
        $this->assertCount(2, $cities);

        // Check response data.
        foreach ($cities as $key => $city) {
            $cityId = $key + 1;
            $this->assertInstanceOf(CityInterface::class, $city);
            $this->assertCityResponseData($city, $cityId);
        }
    }

    public function testRequestCityByDistrictId(): void
    {
        $responseData = $this->getRequestCityResponseData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $districtId = 1;
        $nameUa = 'Name UA';
        $cityCollection = $this->addressClassifier->requestCityByDistrictId($districtId, $nameUa);

        // Base assertions.
        $this->assertInstanceOf(CityCollectionInterface::class, $cityCollection);
        $cities = $cityCollection->all();
        $this->assertCount(2, $cities);

        // Check response data.
        foreach ($cities as $key => $city) {
            $cityId = $key + 1;
            $this->assertInstanceOf(CityInterface::class, $city);
            $this->assertCityResponseData($city, $cityId);
        }
    }

    public function testRequestCityByRegionId(): void
    {
        $responseData = $this->getRequestCityResponseData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regionId = 1;
        $nameUa = 'Name UA';
        $cityCollection = $this->addressClassifier->requestCityByRegionId($regionId, $nameUa);

        // Base assertions.
        $this->assertInstanceOf(CityCollectionInterface::class, $cityCollection);
        $cities = $cityCollection->all();
        $this->assertCount(2, $cities);

        // Check response data.
        foreach ($cities as $key => $city) {
            $cityId = $key + 1;
            $this->assertInstanceOf(CityInterface::class, $city);
            $this->assertCityResponseData($city, $cityId);
        }
    }

    public function testRequestStreetByRegionIdAndDistrictIdAndCityId(): void
    {
        $responseData = [
            'Entries' => [
                'Entry' => [
                    [
                        'STREET_ID' => '1',
                        'STREET_UA' => 'Main Street UA',
                        'STREET_EN' => 'Main Street EN',
                        'STREETTYPE_UA' => 'Street UA',
                        'STREETTYPE_EN' => 'Street EN',
                        'SHORTSTREETTYPE_UA' => 'St UA',
                        'SHORTSTREETTYPE_EN' => 'St EN'
                    ],
                    [
                        'STREET_ID' => '2',
                        'STREET_UA' => 'Second Avenue UA',
                        'STREET_EN' => 'Second Avenue EN',
                        'STREETTYPE_UA' => 'Avenue UA',
                        'STREETTYPE_EN' => 'Avenue EN',
                        'SHORTSTREETTYPE_UA' => 'Ave UA',
                        'SHORTSTREETTYPE_EN' => 'Ave EN'
                    ],
                ]
            ]
        ];
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regionId = 1;
        $districtId = 2;
        $cityId = 3;
        $nameUa = 'name ua';
        $streetCollection = $this->addressClassifier->requestStreetByRegionIdAndDistrictIdAndCityId($regionId, $districtId, $cityId, $nameUa);

        $this->assertInstanceOf(StreetCollectionInterface::class, $streetCollection);
        /** @var StreetInterface[] $streets */
        $streets = $streetCollection->all();
        $this->assertCount(2, $streets);

        $this->assertInstanceOf(StreetInterface::class, $streets[0]);
        $this->assertEquals('1', $streets[0]->getId());
        $this->assertEquals('Main Street UA', $streets[0]->getName()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('Main Street EN', $streets[0]->getName()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals('Street UA', $streets[0]->getType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('Street EN', $streets[0]->getType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals('St UA', $streets[0]->getShortType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('St EN', $streets[0]->getShortType()->getByLanguage(LanguagesEnum::EN));

        $this->assertInstanceOf(StreetInterface::class, $streets[1]);
        $this->assertEquals('2', $streets[1]->getId());
        $this->assertEquals('Second Avenue UA', $streets[1]->getName()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('Second Avenue EN', $streets[1]->getName()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals('Avenue UA', $streets[1]->getType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('Avenue EN', $streets[1]->getType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals('Ave UA', $streets[1]->getShortType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals('Ave EN', $streets[1]->getShortType()->getByLanguage(LanguagesEnum::EN));
    }

    public function testRequestAddressHouseByStreetId(): void
    {
        $responseData = [
            'Entries' => [
                'Entry' => [
                    ['HOUSENUMBER_UA' => '10A', 'POSTCODE' => '12345'],
                    ['HOUSENUMBER_UA' => '10B', 'POSTCODE' => '67890']
                ]
            ]
        ];
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $streetId = 100;
        $houseNumber = '10';
        $houseCollection = $this->addressClassifier->requestAddressHouseByStreetId($streetId, $houseNumber);

        // Verify the response is correctly processed into a HouseCollectionInterface
        $this->assertInstanceOf(HouseCollectionInterface::class, $houseCollection);
        /** @var HouseInterface[] $houses */
        $houses = $houseCollection->all();
        $this->assertCount(2, $houses);

        // Further assertions to verify the details of the houses
        $this->assertInstanceOf(HouseInterface::class, $houses[0]);
        $this->assertEquals('10A', $houses[0]->getHouseNumber());
        $this->assertEquals(12345, $houses[0]->getPostCode());

        $this->assertInstanceOf(HouseInterface::class, $houses[1]);
        $this->assertEquals('10B', $houses[1]->getHouseNumber());
        $this->assertEquals(67890, $houses[1]->getPostCode());
    }

    public function testRequestCourierAreaByPostCode1(): void
    {
        $responseData = ['Entries' => ['Entry' => [['IS_COURIERAREA' => '1']]]];
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));
        $postCode = 12345;
        $courierArea = $this->addressClassifier->requestCourierAreaByPostCode($postCode);
        $this->assertInstanceOf(CourierAreaInterface::class, $courierArea);
        $this->assertTrue($courierArea->isCourierArea());
    }

    public function testRequestCourierAreaByPostCode2(): void
    {
        $responseData = ['Entries' => ['Entry' => [['IS_COURIERAREA' => '0']]]];
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));
        $postCode = 67890;
        $courierArea = $this->addressClassifier->requestCourierAreaByPostCode($postCode);
        $this->assertInstanceOf(CourierAreaInterface::class, $courierArea);
        $this->assertFalse($courierArea->isCourierArea());
    }

    public function testRequestCourierAreaByPostCode3(): void
    {
        $responseData = [];
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));
        $postCode = 0;
        $courierArea = $this->addressClassifier->requestCourierAreaByPostCode($postCode);
        $this->assertInstanceOf(CourierAreaInterface::class, $courierArea);
        $this->assertFalse($courierArea->isCourierArea());
    }

    /** @phpstan-ignore-next-line */
    private function getRequestPostOfficesData(): array
    {
        return [
            'Entries' => [
                'Entry' => [
                    [
                        'ID' => '1',
                        'PO_CODE' => '1',
                        'PO_LONG' => 'Name long 1',
                        'PO_SHORT' => 'Name short 1',
                        'TYPE_LONG' => 'Type long 1',
                        'TYPE_SHORT' => 'Type short 1',
                        'TYPE_ACRONYM' => 'Type acronym 1',
                        'POSTINDEX' => '1',
                        'POSTCODE' => '1',
                        'MEREZA_NUMBER' => '1',
                        'POLOCK_UA' => 'Lock UA 1',
                        'POLOCK_EN' => 'Lock EN 1',
                        'LOCK_CODE' => '1',
                        'POREGION_ID' => '1',
                        'PDREGION_ID' => '1',
                        'PODISTRICT_ID' => '1',
                        'PDDISTRICT_ID' => '1',
                        'POCITY_ID' => '1',
                        'CITYTYPE_UA' => 'City type 1',
                        'PDCITY_ID' => '1',
                        'PDCITY_UA' => 'Service area city UA 1',
                        'PDCITY_EN' => 'Service area city EN 1',
                        'PDCITYTYPE_UA' => 'Service area city type UA 1',
                        'PDCITYTYPE_EN' => 'Service area city type EN 1',
                        'SHORTPDCITYTYPE_UA' => 'Service area short city type UA 1',
                        'SHORTPDCITYTYPE_EN' => 'Service area short city type EN 1',
                        'POSTREET_ID' => '1',
                        'PARENT_ID' => '1',
                        'ADDRESS' => 'Address 1',
                        'PHONE' => '1-123',
                        'LONGITUDE' => '1.123',
                        'LATTITUDE' => '2.123',
                        'ISVPZ' => '1',
                        'AVALIBLE' => '1',
                        'MRTPS' => '1',
                        'TECHINDEX' => '1',
                        'IS_NODISTRICT' => '0',
                    ],
                    [
                        'ID' => '2',
                        'PO_CODE' => '2',
                        'PO_LONG' => 'Name long 2',
                        'PO_SHORT' => 'Name short 2',
                        'TYPE_LONG' => 'Type long 2',
                        'TYPE_SHORT' => 'Type short 2',
                        'TYPE_ACRONYM' => 'Type acronym 2',
                        'POSTINDEX' => '2',
                        'POSTCODE' => '2',
                        'MEREZA_NUMBER' => '2',
                        'POLOCK_UA' => 'Lock UA 2',
                        'POLOCK_EN' => 'Lock EN 2',
                        'LOCK_CODE' => '2',
                        'POREGION_ID' => '2',
                        'PDREGION_ID' => '2',
                        'PODISTRICT_ID' => '2',
                        'PDDISTRICT_ID' => '2',
                        'POCITY_ID' => '2',
                        'CITYTYPE_UA' => 'City type 2',
                        'PDCITY_ID' => '2',
                        'PDCITY_UA' => 'Service area city UA 2',
                        'PDCITY_EN' => 'Service area city EN 2',
                        'PDCITYTYPE_UA' => 'Service area city type UA 2',
                        'PDCITYTYPE_EN' => 'Service area city type EN 2',
                        'SHORTPDCITYTYPE_UA' => 'Service area short city type UA 2',
                        'SHORTPDCITYTYPE_EN' => 'Service area short city type EN 2',
                        'POSTREET_ID' => '2',
                        'PARENT_ID' => '2',
                        'ADDRESS' => 'Address 2',
                        'PHONE' => '2-123',
                        'LONGITUDE' => '2.123',
                        'LATTITUDE' => '3.123',
                        'ISVPZ' => '0',
                        'AVALIBLE' => '0',
                        'TECHINDEX' => '2',
                        'IS_NODISTRICT' => '1',
                    ],
                ],
            ],
        ];
    }

    private function assertPostOfficeResponseData(PostOfficeInterface $postOffice, int $postOfficeId): void
    {
        $this->assertEquals($postOfficeId, $postOffice->getId());
        $this->assertEquals($postOfficeId, $postOffice->getCode());
        $this->assertEquals("Name long $postOfficeId", $postOffice->getName());
        $this->assertEquals("Name short $postOfficeId", $postOffice->getShortName());
        $this->assertEquals("Type long $postOfficeId", $postOffice->getType());
        $this->assertEquals("Type short $postOfficeId", $postOffice->getShortType());
        $this->assertEquals("Type acronym $postOfficeId", $postOffice->getTypeAcronymName());
        $this->assertEquals($postOfficeId, $postOffice->getPostIndex());
        $this->assertEquals($postOfficeId, $postOffice->getPostCode());
        $this->assertEquals($postOfficeId, $postOffice->getMerezaNumber());
        $this->assertEquals("Lock UA $postOfficeId", $postOffice->getLock()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("Lock EN $postOfficeId", $postOffice->getLock()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals($postOfficeId, $postOffice->getLockCode());
        $this->assertEquals($postOfficeId, $postOffice->getRegionId());
        $this->assertEquals($postOfficeId, $postOffice->getServiceAreaRegionId());
        $this->assertEquals($postOfficeId, $postOffice->getDistrictId());
        $this->assertEquals($postOfficeId, $postOffice->getServiceAreaDistrictId());
        $this->assertEquals($postOfficeId, $postOffice->getCityId());
        $this->assertEquals("City type $postOfficeId", $postOffice->getCityType());
        $this->assertEquals($postOfficeId, $postOffice->getServiceAreaCityId());
        $this->assertEquals("Service area city UA $postOfficeId", $postOffice->getServiceAreaCity()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("Service area city EN $postOfficeId", $postOffice->getServiceAreaCity()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals("Service area city type UA $postOfficeId", $postOffice->getServiceAreaCityType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("Service area city type EN $postOfficeId", $postOffice->getServiceAreaCityType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals("Service area short city type UA $postOfficeId", $postOffice->getServiceAreaShortCityType()->getByLanguage(LanguagesEnum::UA));
        $this->assertEquals("Service area short city type EN $postOfficeId", $postOffice->getServiceAreaShortCityType()->getByLanguage(LanguagesEnum::EN));
        $this->assertEquals($postOfficeId, $postOffice->getStreetId());
        $this->assertEquals($postOfficeId, $postOffice->getParentId());
        $this->assertEquals("Address $postOfficeId", $postOffice->getAddress());
        $this->assertEquals("$postOfficeId-123", $postOffice->getPhoneNumber());
        $this->assertEquals((float) ("$postOfficeId.123"), $postOffice->getLongitude());
        $this->assertEquals((float) (($postOfficeId + 1) . '.123'), $postOffice->getLatitude());
        $this->assertEquals($postOfficeId === 1, $postOffice->isVpz());
        $this->assertEquals($postOfficeId === 1, $postOffice->isAvailable());
        $this->assertEquals($postOfficeId === 1 ? 1 : null, $postOffice->getMrtps());
        $this->assertEquals($postOfficeId, $postOffice->getTechIndex());
        $this->assertEquals($postOfficeId === 1, $postOffice->isDeliveryPossible());
    }

    public function testRequestPostOfficeByPostCode(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $postCode = 123;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByPostCode($postCode);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByPostIndex(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $postIndex = 321;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByPostIndex($postIndex);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByCityId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $cityId = 123;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByCityId($cityId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByDistrictId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $districtId = 321;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByDistrictId($districtId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByStreetId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $streetId = 123;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByStreetId($streetId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByRegionId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regionId = 321;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByRegionId($regionId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByServiceAreaCityId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $serviceAreaCityId = 123;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByServiceAreaCityId($serviceAreaCityId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByServiceAreaDistrictId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $serviceAreaDistrictId = 321;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByServiceAreaDistrictId($serviceAreaDistrictId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    public function testRequestPostOfficeByServiceAreaRegionId(): void
    {
        $responseData = $this->getRequestPostOfficesData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $serviceAreRegionId = 123;
        $postOfficeCollection = $this->addressClassifier->requestPostOfficeByServiceAreaRegionId($serviceAreRegionId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeCollectionInterface::class, $postOfficeCollection);
        $postOffices = $postOfficeCollection->all();
        $this->assertCount(2, $postOffices);

        // Check response data.
        foreach ($postOffices as $key => $postOffice) {
            $postOfficeId = $key + 1;
            $this->assertInstanceOf(PostOfficeInterface::class, $postOffice);
            $this->assertPostOfficeResponseData($postOffice, $postOfficeId);
        }
    }

    /** @phpstan-ignore-next-line */
    private function getRequestPostOfficeSettlementData(): array
    {
        return [
          'Entries' => [
              'Entry' => [
                  [
                      'ID' => '1',
                      'PO_LONG' => 'Main Office 1',
                      'PO_SHORT' => 'MO 1',
                      'TYPE_LONG' => 'Office Type 1',
                      'TYPE_SHORT' => 'OT 1',
                      'TYPE_ACRONYM' => 'OTA 1',
                      'PARENT_ID' => '2',
                      'CITY_ID' => '3',
                      'CITY_UA' => 'CityName 1 UA',
                      'CITY_EN' => 'CityName 1 EN',
                      'CITYTYPE_UA' => 'CityType 1 UA',
                      'CITYTYPE_EN' => 'CityType 1 EN',
                      'SHORTCITYTYPE_UA' => 'ShortCityType 1 UA',
                      'SHORTCITYTYPE_EN' => 'ShortCityType 1 EN',
                      'POSTINDEX' => '111',
                      'REGION_ID' => '4',
                      'REGION_UA' => 'RegionName 1 UA',
                      'REGION_EN' => 'RegionName 1 EN',
                      'DISTRICT_ID' => '5',
                      'DISTRICT_UA' => 'DistrictName 1 UA',
                      'DISTRICT_EN' => 'DistrictName 1 EN',
                      'STREET_UA' => 'StreetName 1 UA',
                      'STREET_EN' => 'StreetName 1 EN',
                      'STREETTYPE_UA' => 'StreetType 1 UA',
                      'STREETTYPE_EN' => 'StreetType 1 EN',
                      'HOUSENUMBER' => '1A',
                      'ADDRESS' => '1 Main Street',
                      'LONGITUDE' => '10.1111',
                      'LATTITUDE' => '20.2222',
                      'IS_CASH' => '1',
                      'IS_DHL' => '0',
                      'IS_SMARTBOX' => '1',
                      'PELPEREKAZY' => '0',
                      'IS_FLAGMAN' => '1',
                      'POSTTERMINAL' => '0',
                      'IS_AUTOMATED' => '1',
                      'IS_SECURITY' => '0',
                      'LOCK_CODE' => '111',
                      'LOCK_UA' => 'LockReason 1 UA',
                      'LOCK_EN' => 'LockReason 1 EN',
                      'PHONE' => '111-111',
                      'ISVPZ' => '1',
                      'MEREZA_NUMBER' => '1222',
                      'TECHINDEX' => '222',
                  ],
                  [
                      'ID' => '2',
                      'PO_LONG' => 'Main Office 2',
                      'PO_SHORT' => 'MO 2',
                      'TYPE_LONG' => 'Office Type 2',
                      'TYPE_SHORT' => 'OT 2',
                      'TYPE_ACRONYM' => 'OTA 2',
                      'PARENT_ID' => '3',
                      'CITY_ID' => '4',
                      'CITY_UA' => 'CityName 2 UA',
                      'CITY_EN' => 'CityName 2 EN',
                      'CITYTYPE_UA' => 'CityType 2 UA',
                      'CITYTYPE_EN' => 'CityType 2 EN',
                      'SHORTCITYTYPE_UA' => 'ShortCityType 2 UA',
                      'SHORTCITYTYPE_EN' => 'ShortCityType 2 EN',
                      'POSTINDEX' => '222',
                      'REGION_ID' => '5',
                      'REGION_UA' => 'RegionName 2 UA',
                      'REGION_EN' => 'RegionName 2 EN',
                      'DISTRICT_ID' => '6',
                      'DISTRICT_UA' => 'DistrictName 2 UA',
                      'DISTRICT_EN' => 'DistrictName 2 EN',
                      'STREET_UA' => 'StreetName 2 UA',
                      'STREET_EN' => 'StreetName 2 EN',
                      'STREETTYPE_UA' => 'StreetType 2 UA',
                      'STREETTYPE_EN' => 'StreetType 2 EN',
                      'HOUSENUMBER' => '2A',
                      'ADDRESS' => '2 Main Street',
                      'LONGITUDE' => '20.2222',
                      'LATTITUDE' => '30.3333',
                      'IS_CASH' => '0',
                      'IS_DHL' => '1',
                      'IS_SMARTBOX' => '0',
                      'PELPEREKAZY' => '1',
                      'IS_FLAGMAN' => '0',
                      'POSTTERMINAL' => '1',
                      'IS_AUTOMATED' => '0',
                      'IS_SECURITY' => '1',
                      'LOCK_CODE' => '222',
                      'LOCK_UA' => 'LockReason 2 UA',
                      'LOCK_EN' => 'LockReason 2 EN',
                      'PHONE' => '222-222',
                      'ISVPZ' => '0',
                      'MEREZA_NUMBER' => '2333',
                      'TECHINDEX' => '333',
                  ],
              ],
          ],
        ];
    }

    private function assertPostOfficeSettlementsResponseData(PostOfficeSettlementInterface $postOfficeSettlement, int $postOfficeSettlementId): void
    {
        $this->assertEquals($postOfficeSettlementId, $postOfficeSettlement->getId());
        $this->assertEquals("Main Office $postOfficeSettlementId", $postOfficeSettlement->getName());
        $this->assertEquals("MO $postOfficeSettlementId", $postOfficeSettlement->getShortName());
        $this->assertEquals("Office Type $postOfficeSettlementId", $postOfficeSettlement->getType());
        $this->assertEquals("OT $postOfficeSettlementId", $postOfficeSettlement->getShortType());
        $this->assertEquals("OTA $postOfficeSettlementId", $postOfficeSettlement->getTypeAcronym());
        $this->assertEquals($postOfficeSettlementId + 1, $postOfficeSettlement->getParentId());
        $this->assertEquals($postOfficeSettlementId + 2, $postOfficeSettlement->getCityId());
        $this->assertEquals(
            ['ua' => "CityName $postOfficeSettlementId UA", 'en' => "CityName $postOfficeSettlementId EN"],
            $postOfficeSettlement->getCity()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => "CityType $postOfficeSettlementId UA", 'en' => "CityType $postOfficeSettlementId EN"],
            $postOfficeSettlement->getCityType()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => "ShortCityType $postOfficeSettlementId UA", 'en' => "ShortCityType $postOfficeSettlementId EN"],
            $postOfficeSettlement->getShortCityType()->getByLangOrArray()
        );
        $this->assertEquals((int) str_repeat((string) $postOfficeSettlementId, 3), $postOfficeSettlement->getPostIndex());
        $this->assertEquals($postOfficeSettlementId + 3, $postOfficeSettlement->getRegionId());
        $this->assertEquals(
            ['ua' => "RegionName {$postOfficeSettlementId} UA", 'en' => "RegionName {$postOfficeSettlementId} EN"],
            $postOfficeSettlement->getRegion()->getByLangOrArray()
        );
        $this->assertEquals($postOfficeSettlementId + 4, $postOfficeSettlement->getDistrictId());
        $this->assertEquals(
            ['ua' => "DistrictName {$postOfficeSettlementId} UA", 'en' => "DistrictName {$postOfficeSettlementId} EN"],
            $postOfficeSettlement->getDistrict()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => "StreetName {$postOfficeSettlementId} UA", 'en' => "StreetName {$postOfficeSettlementId} EN"],
            $postOfficeSettlement->getStreet()->getByLangOrArray()
        );
        $this->assertEquals(
            ['ua' => "StreetType {$postOfficeSettlementId} UA", 'en' => "StreetType {$postOfficeSettlementId} EN"],
            $postOfficeSettlement->getStreetType()->getByLangOrArray()
        );
        $this->assertEquals("{$postOfficeSettlementId}A", $postOfficeSettlement->getHouseNumber());
        $this->assertEquals("$postOfficeSettlementId Main Street", $postOfficeSettlement->getAddress());
        $this->assertEquals(
            (float) ("{$postOfficeSettlementId}0." . str_repeat((string) $postOfficeSettlementId, 4)),
            $postOfficeSettlement->getLongitude()
        );
        $this->assertEquals(
            (float) (($postOfficeSettlementId + 1) . '0.' . str_repeat((string) ($postOfficeSettlementId + 1), 4)),
            $postOfficeSettlement->getLatitude()
        );
        $this->assertEquals($postOfficeSettlementId === 1, $postOfficeSettlement->isCash());
        $this->assertEquals($postOfficeSettlementId !== 1, $postOfficeSettlement->isDhl());
        $this->assertEquals($postOfficeSettlementId === 1, $postOfficeSettlement->isSmartbox());
        $this->assertEquals($postOfficeSettlementId !== 1, $postOfficeSettlement->isUrgentPostalTransfers());
        $this->assertEquals($postOfficeSettlementId === 1, $postOfficeSettlement->isFlagman());
        $this->assertEquals($postOfficeSettlementId !== 1, $postOfficeSettlement->hasPostTerminal());
        $this->assertEquals($postOfficeSettlementId === 1, $postOfficeSettlement->isAutomated());
        $this->assertEquals($postOfficeSettlementId !== 1, $postOfficeSettlement->isSecurity());
        $this->assertEquals((int) str_repeat((string) $postOfficeSettlementId, 3), $postOfficeSettlement->getLockCode());
        $this->assertEquals(
            ['ua' => "LockReason $postOfficeSettlementId UA", 'en' => "LockReason {$postOfficeSettlementId} EN"],
            $postOfficeSettlement->getLock()->getByLangOrArray()
        );
        $phone_part = str_repeat((string) $postOfficeSettlementId, 3);
        $this->assertEquals("$phone_part-$phone_part", $postOfficeSettlement->getPhone());
        $this->assertEquals($postOfficeSettlementId === 1, $postOfficeSettlement->isVpz());
        $this->assertEquals(
            $postOfficeSettlementId . str_repeat((string) ($postOfficeSettlementId + 1), 3),
            $postOfficeSettlement->getMerezaNumber()
        );
        $this->assertEquals(
            str_repeat((string) ($postOfficeSettlementId + 1), 3),
            $postOfficeSettlement->getTechIndex()
        );
    }

    public function testRequestPostOfficeSettlementsByCityId(): void
    {
        $responseData = $this->getRequestPostOfficeSettlementData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $cityId = 123;
        $postOfficeSettlementCollection = $this->addressClassifier->requestPostOfficeSettlementsByCityId($cityId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeSettlementCollection::class, $postOfficeSettlementCollection);
        $postOfficeSettlements = $postOfficeSettlementCollection->all();
        $this->assertCount(2, $postOfficeSettlements);

        // Check response data.
        foreach ($postOfficeSettlements as $key => $postOfficeSettlement) {
            $postOfficeSettlementId = $key + 1;
            $this->assertInstanceOf(PostOfficeSettlementInterface::class, $postOfficeSettlement);
            $this->assertPostOfficeSettlementsResponseData($postOfficeSettlement, $postOfficeSettlementId);
        }
    }

    public function testRequestPostOfficeSettlementsByDistrictId(): void
    {
        $responseData = $this->getRequestPostOfficeSettlementData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $districtId = 321;
        $postOfficeSettlementCollection = $this->addressClassifier->requestPostOfficeSettlementsByDistrictId($districtId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeSettlementCollection::class, $postOfficeSettlementCollection);
        $postOfficeSettlements = $postOfficeSettlementCollection->all();
        $this->assertCount(2, $postOfficeSettlements);

        // Check response data.
        foreach ($postOfficeSettlements as $key => $postOfficeSettlement) {
            $postOfficeSettlementId = $key + 1;
            $this->assertInstanceOf(PostOfficeSettlementInterface::class, $postOfficeSettlement);
            $this->assertPostOfficeSettlementsResponseData($postOfficeSettlement, $postOfficeSettlementId);
        }
    }

    public function testRequestPostOfficeSettlementsByRegionId(): void
    {
        $responseData = $this->getRequestPostOfficeSettlementData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $regionId = 111;
        $postOfficeSettlementCollection = $this->addressClassifier->requestPostOfficeSettlementsByRegionId($regionId);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeSettlementCollection::class, $postOfficeSettlementCollection);
        $postOfficeSettlements = $postOfficeSettlementCollection->all();
        $this->assertCount(2, $postOfficeSettlements);

        // Check response data.
        foreach ($postOfficeSettlements as $key => $postOfficeSettlement) {
            $postOfficeSettlementId = $key + 1;
            $this->assertInstanceOf(PostOfficeSettlementInterface::class, $postOfficeSettlement);
            $this->assertPostOfficeSettlementsResponseData($postOfficeSettlement, $postOfficeSettlementId);
        }
    }

    public function testRequestPostOfficeSettlementsByPostIndex(): void
    {
        $responseData = $this->getRequestPostOfficeSettlementData();
        $this->requestMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($this->getMockResponse($responseData));

        $postIndex = 222;
        $postOfficeSettlementCollection = $this->addressClassifier->requestPostOfficeSettlementsByPostIndex($postIndex);

        // Base assertions.
        $this->assertInstanceOf(PostOfficeSettlementCollection::class, $postOfficeSettlementCollection);
        $postOfficeSettlements = $postOfficeSettlementCollection->all();
        $this->assertCount(2, $postOfficeSettlements);

        // Check response data.
        foreach ($postOfficeSettlements as $key => $postOfficeSettlement) {
            $postOfficeSettlementId = $key + 1;
            $this->assertInstanceOf(PostOfficeSettlementInterface::class, $postOfficeSettlement);
            $this->assertPostOfficeSettlementsResponseData($postOfficeSettlement, $postOfficeSettlementId);
        }
    }

}
