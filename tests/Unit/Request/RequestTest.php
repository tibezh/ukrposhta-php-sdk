<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Request;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Handler\MockHandler;
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
use Ukrposhta\Tests\Utils\FakerGeneratorTrait;

#[CoversClass(Request::class)]
#[CoversClass(RequestInterface::class)]
#[Medium]
class RequestTest extends TestCase {

  use FakerGeneratorTrait;

  public function testConstructBase(): void {
    $request = new Request();
    $this->assertInstanceOf(RequestInterface::class, $request);
    $this->assertInstanceOf(LoggerAwareInterface::class, $request);
  }

  public function testConstructFailedArgs(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new Request(true);
  }

  public function testConstructCustomArgs(): void {
    $logger = new NullLogger();
    $request = new Request($logger);

    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('logger');
    $requestLogger = $property->getValue($request);

    $this->assertSame($logger, $requestLogger);
  }

  public function testSetLogger(): void {
    $logger = new class extends AbstractLogger {
      /** @phpstan-ignore-next-line */
      public function log($level, \Stringable|string $message, array $context = []): void {}
    };

    $request = new Request();
    $request->setLogger($logger);;

    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('logger');
    $requestLogger = $property->getValue($request);

    $this->assertSame($logger, $requestLogger);
  }

  public function testGetEndpointUrlEmpty(): void {
    $endpoint = (new Request())->getEndpointUrl();
    $this->assertSame('', $endpoint);
  }

  public function testGetEndpointUrlAvailable(): void {
    $endpointUrl = $this->fakerGenerator()->url();
    $endpoint = (new Request())
      ->setEndpointUrl($endpointUrl)
      ->getEndpointUrl();
    $this->assertSame($endpointUrl, $endpoint);
  }

  public function testSetEndpointUrlFailed(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->setEndpointUrl(null);
  }

  public function testSetEndpointUrl(): void {
    $endpointUrl = $this->fakerGenerator()->url();
    $request = (new Request())->setEndpointUrl($endpointUrl);

    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('endpointUrl');
    $requestEndpointUrl = $property->getValue($request);

    $this->assertSame($endpointUrl, $requestEndpointUrl);
  }

  public function testGetRequestEmpty(): void {
    $request = (new Request())->getRequest();
    $this->assertSame([], $request);
  }

  public function testGetRequestAvailable(): void {
    $fakeRequestData = [
      'digit' => $this->fakerGenerator()->randomDigit(),
      'string' => $this->fakerGenerator()->word(),
      'bool' => $this->fakerGenerator()->boolean(),
      'number' => $this->fakerGenerator()->randomNumber(),
    ];
    $requestData = (new Request())->setRequest($fakeRequestData)->getRequest();

    $this->assertSame($fakeRequestData['digit'], $requestData['digit']);
    $this->assertSame($fakeRequestData['string'], $requestData['string']);
    $this->assertSame($fakeRequestData['bool'], $requestData['bool']);
    $this->assertSame($fakeRequestData['number'], $requestData['number']);
  }


  public function testSetRequestFailedArgs(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->setRequest(null);
  }

  public function testSetRequest(): void {
    $fakeRequestData = [$this->fakerGenerator()->word() => $this->fakerGenerator()->randomDigit()];

    $request = (new Request())->setRequest($fakeRequestData);
    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('request');
    $requestData = $property->getValue($request);

    $this->assertSame($fakeRequestData, $requestData);
  }

  public function testGetAccess(): void {
    $access = (new Request())->getAccess();
    $this->assertSame('', $access);
  }

  public function testSetAccessFailed(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->setAccess(null);
  }

  public function testSetAccess(): void {
    $fakeAccessData = $this->fakerGenerator()->uuid();

    $request = (new Request())->setAccess($fakeAccessData);
    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('access');
    $accessData = $property->getValue($request);

    $this->assertSame($fakeAccessData, $accessData);
  }

  public function testSetClient(): void {
    $request = (new Request());
    $reflection = new \ReflectionClass($request);
    $property = $reflection->getProperty('client');
    $client = $property->getValue($request);

    $this->assertInstanceOf(Guzzle::class, $client);
  }

  public function testGetRequestOptions(): void {
    $bearer = $this->fakerGenerator()->uuid();
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

  public function testRequestNoArgsFail1(): void {
    $this->expectException(\ArgumentCountError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->request();
  }

  public function testRequestNoArgsFail2(): void {
    $this->expectException(\ArgumentCountError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->request(access: $this->fakerGenerator()->uuid());
  }

  public function testRequestNoArgsFail3(): void {
    $this->expectException(\ArgumentCountError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->request(access: $this->fakerGenerator()->uuid(), method: 'GET');
  }

  public function testRequestTypeArgsFail1(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->request(access: null, method: 'GET', endpointUrl: $this->fakerGenerator()->url());
  }

  public function testRequestTypeArgsFail2(): void {
    $this->expectException(\TypeError::class);
    (new Request())->request(
      access: $this->fakerGenerator()->uuid(),
      /** @phpstan-ignore-next-line */
      method: null,
      endpointUrl: $this->fakerGenerator()->url()
    );
  }

  public function testRequestTypeArgsFail3(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    (new Request())->request(access: $this->fakerGenerator()->uuid(), method: 'GET', endpointUrl: null);
  }

  public function testRequestBase(): void {
    $fakeResponseData = $this->fakerGenerator()->randomElements(count: 3);
    $mock = new MockHandler([
      new GuzzleResponse(200, [], (string) json_encode($fakeResponseData)),
    ]);

    $handler = HandlerStack::create($mock);
    $guzzleClient = new Guzzle(['handler' => $handler]);

    $request = new Request();
    $request->setClient($guzzleClient);

    $access = $this->fakerGenerator()->uuid();
    $method = 'GET';
    $endpointUrl = $this->fakerGenerator()->url();

    $response = $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
    $this->assertSame($fakeResponseData, $response->getResponseData());
  }

  public function testRequestInvalidResponseException(): void {
    $mock = new MockHandler([new GuzzleResponse(201, [], '{}')]);

    $handler = HandlerStack::create($mock);
    $guzzleClient = new Guzzle(['handler' => $handler]);

    $request = new Request();
    $request->setClient($guzzleClient);

    $access = $this->fakerGenerator()->uuid();
    $method = 'GET';
    $endpointUrl = $this->fakerGenerator()->url();

    $this->expectException(InvalidResponseException::class);
    $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
  }

  public function testRequestBaseRequestException(): void {
    $mock = new MockHandler([new TransferException()]);

    $handler = HandlerStack::create($mock);
    $guzzleClient = new Guzzle(['handler' => $handler]);

    $request = new Request();
    $request->setClient($guzzleClient);

    $access = $this->fakerGenerator()->uuid();
    $method = 'GET';
    $endpointUrl = $this->fakerGenerator()->url();

    $this->expectException(RequestException::class);
    $request->request(access: $access, method: $method, endpointUrl: $endpointUrl);
  }

}
