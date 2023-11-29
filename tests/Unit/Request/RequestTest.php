<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Request;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Medium;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\NullLogger;
use Ukrposhta\Exceptions\InvalidResponseException;
use Ukrposhta\Exceptions\RequestException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;

#[CoversClass(Request::class)]
#[CoversClass(RequestInterface::class)]
#[Medium]
class RequestTest extends TestCase
{

    public function testConstructBase(): void
    {
        $request = new Request();
        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertInstanceOf(LoggerAwareInterface::class, $request);
    }

    public function testConstructFailedArgs(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Request(true);
    }

    public function testConstructCustomArgs(): void
    {
        $logger = new NullLogger();
        $request = new Request($logger);

        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('logger');
        $requestLogger = $property->getValue($request);

        $this->assertSame($logger, $requestLogger);
    }

    public function testSetLogger(): void
    {
        $logger = new class() extends AbstractLogger {
            /** @phpstan-ignore-next-line */
            public function log($level, \Stringable|string $message, array $context = []): void
            {
            }
        };

        $request = new Request();
        $request->setLogger($logger);

        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('logger');
        $requestLogger = $property->getValue($request);

        $this->assertSame($logger, $requestLogger);
    }

    public function testGetEndpointUrlEmpty(): void
    {
        $endpoint = (new Request())->getEndpointUrl();
        $this->assertSame('', $endpoint);
    }

    public function testGetEndpointUrlAvailable(): void
    {
        $endpointUrl = 'https://example.com/get-endpoint';
        $endpoint = (new Request())
          ->setEndpointUrl($endpointUrl)
          ->getEndpointUrl();
        $this->assertSame($endpointUrl, $endpoint);
    }

    public function testSetEndpointUrlFailed(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->setEndpointUrl(null);
    }

    public function testSetEndpointUrl(): void
    {
        $endpointUrl = 'https://example.com/set-endpoint';
        $request = (new Request())->setEndpointUrl($endpointUrl);

        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('endpointUrl');
        $requestEndpointUrl = $property->getValue($request);

        $this->assertSame($endpointUrl, $requestEndpointUrl);
    }

    public function testGetRequestEmpty(): void
    {
        $request = (new Request())->getRequest();
        $this->assertSame([], $request);
    }

    public function testGetRequestAvailable(): void
    {
        $fakeRequestData = [
          'digit' => 0321,
          'string' => 'lorem Ipsum',
          'bool' => true,
          'number' => 321,
        ];
        $requestData = (new Request())->setRequest($fakeRequestData)->getRequest();

        $this->assertSame($fakeRequestData['digit'], $requestData['digit']);
        $this->assertSame($fakeRequestData['string'], $requestData['string']);
        $this->assertSame($fakeRequestData['bool'], $requestData['bool']);
        $this->assertSame($fakeRequestData['number'], $requestData['number']);
    }

    public function testSetRequestFailedArgs(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->setRequest(null);
    }

    public function testSetRequest(): void
    {
        $fakeRequestData = ['foo' => 0412];

        $request = (new Request())->setRequest($fakeRequestData);
        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('request');
        $requestData = $property->getValue($request);

        $this->assertSame($fakeRequestData, $requestData);
    }

    public function testGetAccess(): void
    {
        $access = (new Request())->getAccess();
        $this->assertSame('', $access);
    }

    public function testSetAccessFailed(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->setAccess(null);
    }

    public function testSetAccess(): void
    {
        $fakeAccessData = '74cc7c64-8ec8-11ee-b9d1-0242ac120002';

        $request = (new Request())->setAccess($fakeAccessData);
        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('access');
        $accessData = $property->getValue($request);

        $this->assertSame($fakeAccessData, $accessData);
    }

    public function testSetClient(): void
    {
        $request = (new Request());
        $reflection = new \ReflectionClass($request);
        $property = $reflection->getProperty('client');
        $client = $property->getValue($request);

        $this->assertInstanceOf(Guzzle::class, $client);
    }

    public function testGetRequestOptions(): void
    {
        $bearer = 'fe691e2b-bceb-4d08-a308-8c1b9a9e3d61';
        $requestOptions = [
          'http_errors' => true,
          'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$bearer}",
          ],
        ];

        $request = (new Request())->setAccess($bearer);
        $reflection = new \ReflectionClass($request);
        $method = $reflection->getMethod('getRequestOptions');
        $requestOptionsData = $method->invoke($request);

        $this->assertSame($requestOptions, $requestOptionsData);
    }

    public function testRequestNoArgsFail1(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->request();
    }

    public function testRequestNoArgsFail2(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->request(access: 'a09a933b-5f04-4080-9037-964e809d4a61');
    }

    public function testRequestNoArgsFail3(): void
    {
        $this->expectException(\ArgumentCountError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->request(access: '901f87dc-2c66-4dcf-a7dd-10b7480be020', method: 'GET');
    }

    public function testRequestTypeArgsFail1(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->request(access: null, method: 'GET', endpointUrl: 'https://example.com/type-args-fail1');
    }

    public function testRequestTypeArgsFail2(): void
    {
        $this->expectException(\TypeError::class);
        (new Request())->request(
            access: '6d072b2e-3382-4b5c-8d97-45dadbc159a5',
            /** @phpstan-ignore-next-line */
            method: null,
            endpointUrl: 'https://example.com/type-args-fail2'
        );
    }

    public function testRequestTypeArgsFail3(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        (new Request())->request(access: '3dd5951c-a99c-412a-8bfd-67249a46db61', method: 'GET', endpointUrl: null);
    }

    public function testRequestBase(): void
    {
        $fakeResponseData = ['a' => 'b', 'c' => 'd', 'w' => 'x'];
        $mock = new MockHandler([
          new GuzzleResponse(200, [], (string) json_encode($fakeResponseData)),
        ]);

        $handler = HandlerStack::create($mock);
        $guzzleClient = new Guzzle(['handler' => $handler]);

        $request = new Request();
        $request->setClient($guzzleClient);

        $access = 'cc992de8-b583-4395-b1fd-1497f8801c3c';
        $method = 'GET';
        $endpointUrl = 'https://example.com/base';

        $response = $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
        $this->assertSame($fakeResponseData, $response->getResponseData());
    }

    public function testRequestInvalidResponseException(): void
    {
        $mock = new MockHandler([new GuzzleResponse(201, [], '{}')]);

        $handler = HandlerStack::create($mock);
        $guzzleClient = new Guzzle(['handler' => $handler]);

        $request = new Request();
        $request->setClient($guzzleClient);

        $access = '6d3a3f89-b094-4c9a-bd64-9185016afe85';
        $method = 'GET';
        $endpointUrl = 'https://example.com/invalid-response-exception';

        $this->expectException(InvalidResponseException::class);
        $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
    }

    public function testRequestBaseRequestException(): void
    {
        $mock = new MockHandler([new TransferException()]);

        $handler = HandlerStack::create($mock);
        $guzzleClient = new Guzzle(['handler' => $handler]);

        $request = new Request();
        $request->setClient($guzzleClient);

        $access = '1571af86-3908-40b9-9cd6-1eb8e4b67592';
        $method = 'GET';
        $endpointUrl = 'https://example.com/request-exception';

        $this->expectException(RequestException::class);
        $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
    }
}
