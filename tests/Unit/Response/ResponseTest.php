<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Response;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Ukrposhta\Response\Response;
use Ukrposhta\Response\ResponseInterface;
use Ukrposhta\Tests\Utils\FakerGeneratorTrait;

#[CoversClass(Response::class)]
#[CoversClass(ResponseInterface::class)]
#[Small]
class ResponseTest extends TestCase
{
    use FakerGeneratorTrait;

    public function testConstructBase(): void
    {
        $response = new Response(['foo' => 'bar']);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testConstructNoArgs(): void
    {
        $response = new Response();
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testConstructFailedArgs(): void
    {
        $this->expectException(\TypeError::class);
        /** @phpstan-ignore-next-line */
        new Response(null);
    }

    public function testGetResponseData(): void
    {
        $fakeResponse = [
          'digit' => $this->fakerGenerator()->randomDigit(),
          'string' => $this->fakerGenerator()->word(),
          'bool' => $this->fakerGenerator()->boolean(),
          'number' => $this->fakerGenerator()->randomNumber(),
        ];

        $response = new Response($fakeResponse);
        $responseData = $response->getResponseData();

        $this->assertSame($fakeResponse['digit'], $responseData['digit']);
        $this->assertSame($fakeResponse['string'], $responseData['string']);
        $this->assertSame($fakeResponse['bool'], $responseData['bool']);
        $this->assertSame($fakeResponse['number'], $responseData['number']);
    }
}
