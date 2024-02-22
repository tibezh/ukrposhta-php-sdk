<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\AddressClassifier;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Large;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Ukrposhta\AddressClassifier\AddressClassifier;
use Ukrposhta\AddressClassifier\Entities\District\DistrictInterface;
use Ukrposhta\AddressClassifier\Entities\Region\RegionInterface;
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
            $region_id = $key + 1;
            $this->assertInstanceOf(RegionInterface::class, $region);
            $this->assertEquals($region_id, $region->getId());
            $this->assertEquals("Test Region UA $region_id", $region->getName()->getByLanguage(LanguagesEnum::UA));
            $this->assertEquals("Test Region EN $region_id", $region->getName()->getByLanguage(LanguagesEnum::EN));
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
            $district_id = $key + 1;
            $this->assertInstanceOf(DistrictInterface::class, $district);
            $this->assertEquals($district_id, $district->getId());
            $this->assertEquals("District $district_id UA", $district->getName()->getByLanguage(LanguagesEnum::UA));
            $this->assertEquals("District $district_id EN", $district->getName()->getByLanguage(LanguagesEnum::EN));
            $this->assertEquals($key === 0 ? 123 : 321, $district->getKoatuu());
            $this->assertEquals($key === 0 ? 321 : 123, $district->getKatottg());
        }
    }

}
