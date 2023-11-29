<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Response\Response;
use Ukrposhta\Tracking\Tracking;
use Ukrposhta\Tracking\TrackingInterface;
use Ukrposhta\Tracking\TrackingRouteInterface;
use Ukrposhta\Tracking\TrackingStatusCollectionInterface;
use Ukrposhta\Tracking\TrackingStatusInterface;

#[CoversClass(Tracking::class)]
#[Medium]
class TrackingTest extends TestCase
{

    public function testInterface(): void
    {
        $tracking = new Tracking();
        $this->assertInstanceOf(TrackingInterface::class, $tracking);
    }

    public function testBaseEndpointConst(): void
    {
        $baseEndpoint = Tracking::BASE_ENDPOINT;
        $this->assertSame('status-tracking', $baseEndpoint);
    }

    public function testCredentialsTypeConst(): void
    {
        $credentialsType = Tracking::CREDENTIALS_TYPE;
        $this->assertSame('bearerStatusTracking', $credentialsType);
    }

    public function testBarcodeLastStatusEndpointConst(): void
    {
        $barcodeLastStatusEndpoint = Tracking::BARCODE_LAST_STATUS_ENDPOINT;
        $this->assertSame('/statuses/last', $barcodeLastStatusEndpoint);
    }

    public function testBarcodeStatusesEndpointConst(): void
    {
        $barcodeStatusesEndpoint = Tracking::BARCODE_STATUSES_ENDPOINT;
        $this->assertSame('/statuses', $barcodeStatusesEndpoint);
    }

    public function testBarcodeRouteEndpointConst(): void
    {
        $barcodeRouteEndpoint = Tracking::BARCODE_ROUTE_ENDPOINT;
        $this->assertSame('/barcodes/%s/route', $barcodeRouteEndpoint);
    }

    public function testBarcodeRouteWithLangEndpointConst(): void
    {
        $barcodeRouteWithLangEndpoint = Tracking::BARCODE_ROUTE_WITH_LANG_ENDPOINT;
        $this->assertSame('/barcodes/%s/route/in-lang/%s', $barcodeRouteWithLangEndpoint);
    }

    public function testCanBeCreatedWithValidData1(): void
    {
        // No required params are needed.
        new Tracking();
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData2(): void
    {
        new Tracking(bearerEcom: 'bf4e21d8-5b06-48ac-93a1-6aedcc195665');
        new Tracking(bearerEcom: null);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData3(): void
    {
        new Tracking(bearerStatusTracking: 'c22bfca9-83cf-45b6-a598-74c02d86a2ca');
        new Tracking(bearerStatusTracking: null);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData4(): void
    {
        new Tracking(bearerCounterparty: 'b0d14259-6c4a-4ac2-bce0-dc64fc70240d');
        new Tracking(bearerCounterparty: null);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData5(): void
    {
        new Tracking(sandbox: true);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData6(): void
    {
        new Tracking(logger: new NullLogger());
        new Tracking(logger: null);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithValidData7(): void
    {
        new Tracking(request: new Request());
        new Tracking(request: null);
        $this->expectNotToPerformAssertions();
    }

    public function testCanBeCreatedWithNotValidData1(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(bearerEcom: 12321);
    }

    public function testCanBeCreatedWithNotValidData2(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(bearerStatusTracking: 22334);
    }

    public function testCanBeCreatedWithNotValidData3(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(bearerCounterparty: 3335234);
    }

    public function testCanBeCreatedWithNotValidData4(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(sandbox: 'sandbox 4 sandbox');
    }

    public function testCanBeCreatedWithNotValidData5(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(logger: 'Ukraine logger');
    }

    public function testCanBeCreatedWithNotValidData6(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Tracking(request: true);
    }

    public function testSetAccessTokenValid(): void
    {
        // Make getAccessToken method accessible.
        $reflection = new \ReflectionClass(Tracking::class);
        $method = $reflection->getMethod('getAccessToken');

        // Create Tracking object and apply access token.
        $accessToken = '991fa78f-f082-4cf0-9eec-91c2aee208ab';
        $tracking = (new Tracking())
          ->setAccessToken($accessToken);

        // Compare access token using getAccessToken method.
        $this->assertSame($accessToken, $method->invoke($tracking));
    }

    public function testSetAccessTokenNotValid(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Tracking())->setAccessToken(false);
    }

    public function testGetAccessTokenNotValid(): void
    {
        // Make getAccessToken method accessible.
        $reflection = new \ReflectionClass(Tracking::class);
        $method = $reflection->getMethod('getAccessToken');

        // Create Tracking object without any credentials.
        $tracking = (new Tracking());

        // Catch NoCredentials exception.
        $this->expectException(NoCredentialException::class);
        $method->invoke($tracking);
    }

    public function testGetAccessTokenFromConstructor(): void
    {
        // Make getAccessToken method accessible.
        $reflection = new \ReflectionClass(Tracking::class);
        $method = $reflection->getMethod('getAccessToken');

        // Create Tracking object without any credentials.
        $trackingToken = '82096906-db8a-4211-96dd-644af2d836f8';
        $tracking = (new Tracking(bearerStatusTracking: $trackingToken));

        // Catch NoCredentials exception.
        $this->assertSame($trackingToken, $method->invoke($tracking));
    }

    public function testGetRequestLang(): void
    {
        $tracking = new Tracking();

        // Check default property value return.
        $this->assertSame('UA', $tracking->getRequestLang());

        // Check with updated property.
        $lang = 'UA';
        $reflection = new \ReflectionClass($tracking);
        $property = $reflection->getProperty('requestLang');
        $property->setValue($tracking, $lang);
        $this->assertSame($lang, $tracking->getRequestLang());
    }

    public function testSetRequestLang(): void
    {
        $tracking = new Tracking();

        $lang = 'EN';
        $tracking->setRequestLang($lang);

        $reflection = new \ReflectionClass($tracking);
        $property = $reflection->getProperty('requestLang');

        $this->assertSame($lang, $property->getValue($tracking));
    }

    public function testGetRequest(): void
    {
        $tracking = new Tracking();

        $reflection = new \ReflectionClass($tracking);
        $property = $reflection->getProperty('request');

        $this->assertSame(null, $property->getValue($tracking));

        $request = $tracking->getRequest();
        $this->assertSame($request, $property->getValue($tracking));
    }

    public function testGetEndpointUrl(): void
    {
        $tracking = new Tracking();

        $endpointUrl = $tracking->getEndpointUrl();
        $originalEndpointUrl = Tracking::BASE_URL . Tracking::BASE_ENDPOINT . '/' . Tracking::VERSION;

        $this->assertSame($originalEndpointUrl, $endpointUrl);
    }

    public function testConvertTrackingStatusResponse(): void
    {
        $tracking = new Tracking();

        $reflection = new \ReflectionClass($tracking);
        $method = $reflection->getMethod('convertTrackingStatusResponse');

        $trackingStatusResponseData = TrackingStatusHelper::getRandomTrackingStatusResponseDataFixture();
        $result = $method->invokeArgs($tracking, [$trackingStatusResponseData]);

        $this->assertInstanceOf(TrackingStatusInterface::class, $result);

        $this->assertSame($trackingStatusResponseData['barcode'], $result->getBarcode());
        $this->assertSame($trackingStatusResponseData['step'], $result->getStep());
        $this->assertSame($trackingStatusResponseData['date'], $result->getDate()->format('c'));
        $this->assertSame($trackingStatusResponseData['index'], $result->getIndex());
        $this->assertSame($trackingStatusResponseData['name'], $result->getName());
        $this->assertSame($trackingStatusResponseData['event'], $result->getEventId());
        $this->assertSame($trackingStatusResponseData['eventName'], $result->getEventName());
        $this->assertSame($trackingStatusResponseData['country'], $result->getCountry());
        $this->assertSame($trackingStatusResponseData['eventReason'], $result->getEventReason());
        $this->assertSame($trackingStatusResponseData['eventReason_id'], $result->getEventReasonId());
        $this->assertSame($trackingStatusResponseData['mailType'], $result->getMailType());
        $this->assertSame($trackingStatusResponseData['indexOrder'], $result->getIndexOrder());
    }

    public function testRequestBarcodeRouteBase(): void
    {
        $bearerStatusTrackingAccessToken = '95f0412b-54b3-40c5-90e1-ef0000a4d6b8';
        $barcode = '123213213';
        $endpoint = sprintf(Tracking::BARCODE_ROUTE_ENDPOINT, $barcode);
        $endpointUrl = (new Tracking())->getEndpointUrl() . $endpoint;

        $from = 'address from';
        $to = 'address to';
        $fakeResponse = new Response(['from' => $from, 'to' => $to]);

        $requestMock = $this->createMock(RequestInterface::class);
        $requestMock->expects($this->once())
          ->method('request')
          ->with($bearerStatusTrackingAccessToken, 'GET', $endpointUrl)
          ->willReturn($fakeResponse);

        $tracking = new Tracking(
            bearerStatusTracking: $bearerStatusTrackingAccessToken,
            request: $requestMock
        );
        $route = $tracking->requestBarcodeRoute(barcode: $barcode);

        $this->assertInstanceOf(TrackingRouteInterface::class, $route);

        $this->assertSame($from, $route->getFrom());
        $this->assertSame($to, $route->getTo());
    }

    public function testRequestBarcodeRouteBaseWithEnVersion(): void
    {
        $bearerStatusTrackingAccessToken = 'f34b1db0-a358-4236-abb1-db891f10c0dc';
        $barcode = '3123214123';
        $endpoint = sprintf(Tracking::BARCODE_ROUTE_WITH_LANG_ENDPOINT, $barcode, (new Tracking())->getRequestLang());
        $endpointUrl = (new Tracking())->getEndpointUrl() . $endpoint;

        $from = 'address from en';
        $to = 'address to en';
        $fakeResponse = new Response(['from' => $from, 'to' => $to]);

        $requestMock = $this->createMock(RequestInterface::class);
        $requestMock->expects($this->once())
          ->method('request')
          ->with($bearerStatusTrackingAccessToken, 'GET', $endpointUrl)
          ->willReturn($fakeResponse);

        $tracking = new Tracking(
            bearerStatusTracking: $bearerStatusTrackingAccessToken,
            request: $requestMock
        );
        $route = $tracking->requestBarcodeRoute(barcode: $barcode, en_version: true);

        $this->assertInstanceOf(TrackingRouteInterface::class, $route);

        $this->assertSame($from, $route->getFrom());
        $this->assertSame($to, $route->getTo());
    }

    public function testRequestBarcodeStatuses(): void
    {
        $bearerStatusTrackingAccessToken = '2ddf76b8-0719-4dce-ae3b-f4207c4135d0';
        $barcode = '12214132132';
        $lang = (new Tracking())->getRequestLang();
        $endpoint = sprintf(Tracking::BARCODE_STATUSES_ENDPOINT);
        $endpointUrl = (new Tracking())->getEndpointUrl() . $endpoint;

        $fakeTrackingItems = [
          TrackingStatusHelper::getRandomTrackingStatusResponseDataFixture(),
          TrackingStatusHelper::getRandomTrackingStatusResponseDataFixture(),
        ];
        $fakeResponse = new Response($fakeTrackingItems);

        $requestMock = $this->createMock(RequestInterface::class);
        $requestMock->expects($this->once())
          ->method('request')
          ->with($bearerStatusTrackingAccessToken, 'GET', $endpointUrl, ['barcode' => $barcode, 'lang' => $lang])
          ->willReturn($fakeResponse);

        $tracking = new Tracking(
            bearerStatusTracking: $bearerStatusTrackingAccessToken,
            request: $requestMock
        );
        $trackingStatuses = $tracking->requestBarcodeStatuses(barcode: $barcode);

        $this->assertInstanceOf(TrackingStatusCollectionInterface::class, $trackingStatuses);

        $fakeTrackingStatus1 = $fakeTrackingItems[0];
        $trackingStatus1 = $trackingStatuses->current();
        $this->assertInstanceOf(TrackingStatusInterface::class, $trackingStatus1);
        $this->assertSame($fakeTrackingStatus1['barcode'], $trackingStatus1->getBarcode());
        $this->assertSame($fakeTrackingStatus1['step'], $trackingStatus1->getStep());
        $this->assertSame($fakeTrackingStatus1['date'], $trackingStatus1->getDate()->format('c'));
        $this->assertSame($fakeTrackingStatus1['name'], $trackingStatus1->getName());
        $this->assertSame($fakeTrackingStatus1['event'], $trackingStatus1->getEventId());
        $this->assertSame($fakeTrackingStatus1['eventName'], $trackingStatus1->getEventName());
        $this->assertSame($fakeTrackingStatus1['country'], $trackingStatus1->getCountry());
        $this->assertSame($fakeTrackingStatus1['mailType'], $trackingStatus1->getMailType());
        $this->assertSame($fakeTrackingStatus1['indexOrder'], $trackingStatus1->getIndexOrder());
        $this->assertSame($fakeTrackingStatus1['index'], $trackingStatus1->getIndex());
        $this->assertSame($fakeTrackingStatus1['eventReason'], $trackingStatus1->getEventReason());
        $this->assertSame($fakeTrackingStatus1['eventReason_id'], $trackingStatus1->getEventReasonId());

        $fakeTrackingStatus2 = $fakeTrackingItems[1];
        $trackingStatuses->next();
        $trackingStatus2 = $trackingStatuses->current();
        $this->assertInstanceOf(TrackingStatusInterface::class, $trackingStatus2);
        $this->assertSame($fakeTrackingStatus2['barcode'], $trackingStatus2->getBarcode());
        $this->assertSame($fakeTrackingStatus2['step'], $trackingStatus2->getStep());
        $this->assertSame($fakeTrackingStatus2['date'], $trackingStatus2->getDate()->format('c'));
        $this->assertSame($fakeTrackingStatus2['name'], $trackingStatus2->getName());
        $this->assertSame($fakeTrackingStatus2['event'], $trackingStatus2->getEventId());
        $this->assertSame($fakeTrackingStatus2['eventName'], $trackingStatus2->getEventName());
        $this->assertSame($fakeTrackingStatus2['country'], $trackingStatus2->getCountry());
        $this->assertSame($fakeTrackingStatus2['mailType'], $trackingStatus2->getMailType());
        $this->assertSame($fakeTrackingStatus2['indexOrder'], $trackingStatus2->getIndexOrder());
        $this->assertSame($fakeTrackingStatus2['index'], $trackingStatus2->getIndex());
        $this->assertSame($fakeTrackingStatus2['eventReason'], $trackingStatus2->getEventReason());
        $this->assertSame($fakeTrackingStatus2['eventReason_id'], $trackingStatus2->getEventReasonId());
    }

    public function testRequestBarcodeLastStatus(): void
    {
        $bearerStatusTrackingAccessToken = '3a447154-7496-4a39-b8b5-f84c49974d98';
        $barcode = '32131212213453';
        $lang = (new Tracking())->getRequestLang();
        $endpoint = sprintf(Tracking::BARCODE_LAST_STATUS_ENDPOINT);
        $endpointUrl = (new Tracking())->getEndpointUrl() . $endpoint;

        $fakeTrackingStatus = TrackingStatusHelper::getRandomTrackingStatusResponseDataFixture();
        $fakeResponse = new Response($fakeTrackingStatus);

        $requestMock = $this->createMock(RequestInterface::class);
        $requestMock->expects($this->once())
          ->method('request')
          ->with($bearerStatusTrackingAccessToken, 'GET', $endpointUrl, ['barcode' => $barcode, 'lang' => $lang])
          ->willReturn($fakeResponse);

        $tracking = new Tracking(
            bearerStatusTracking: $bearerStatusTrackingAccessToken,
            request: $requestMock
        );
        $trackingStatus = $tracking->requestBarcodeLastStatus(barcode: $barcode);

        $this->assertInstanceOf(TrackingStatusInterface::class, $trackingStatus);
        $this->assertSame($fakeTrackingStatus['barcode'], $trackingStatus->getBarcode());
        $this->assertSame($fakeTrackingStatus['step'], $trackingStatus->getStep());
        $this->assertSame($fakeTrackingStatus['date'], $trackingStatus->getDate()->format('c'));
        $this->assertSame($fakeTrackingStatus['name'], $trackingStatus->getName());
        $this->assertSame($fakeTrackingStatus['event'], $trackingStatus->getEventId());
        $this->assertSame($fakeTrackingStatus['eventName'], $trackingStatus->getEventName());
        $this->assertSame($fakeTrackingStatus['country'], $trackingStatus->getCountry());
        $this->assertSame($fakeTrackingStatus['mailType'], $trackingStatus->getMailType());
        $this->assertSame($fakeTrackingStatus['indexOrder'], $trackingStatus->getIndexOrder());
        $this->assertSame($fakeTrackingStatus['index'], $trackingStatus->getIndex());
        $this->assertSame($fakeTrackingStatus['eventReason'], $trackingStatus->getEventReason());
        $this->assertSame($fakeTrackingStatus['eventReason_id'], $trackingStatus->getEventReasonId());
    }
}
