<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Ukrposhta;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Ukrposhta\Tests\Utils\FakerGeneratorTrait;
use Ukrposhta\Ukrposhta;

#[CoversClass(Ukrposhta::class)]
#[Small]
final class UkrposhtaTest extends TestCase {

  use FakerGeneratorTrait;

  public function testConstructor(): void {
    $ukrposhta = new UkrposhtaClass();
    $this->assertInstanceOf(Ukrposhta::class, $ukrposhta);
  }

  public function testCannotBeCreatedWithNotValidTypeData1(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new UkrposhtaClass(bearerEcom: $this->fakerGenerator()->randomDigit());
  }

  public function testCannotBeCreatedWithNotValidTypeData2(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new UkrposhtaClass(bearerStatusTracking: $this->fakerGenerator()->randomDigit());
  }

  public function testCannotBeCreatedWithNotValidTypeData3(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new UkrposhtaClass(bearerCounterparty: $this->fakerGenerator()->randomDigit());
  }

  public function testCannotBeCreatedWithNotValidTypeData4(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new UkrposhtaClass(sandbox: $this->fakerGenerator()->randomDigit());
  }

  public function testCannotBeCreatedWithNotValidTypeData5(): void {
    $this->expectException(\TypeError::class);
    /** @phpstan-ignore-next-line */
    new UkrposhtaClass(logger: $this->fakerGenerator()->randomDigit());
  }

  public function testLogger(): void {
    $ukrposhta = new UkrposhtaClass();
    $this->assertNull($ukrposhta->getLogger());
    $logger = new NullLogger();
    $ukrposhta->setLogger($logger);
    $this->assertSame($logger, $ukrposhta->getLogger());
  }

  public function testGetVersionMethod(): void {
    $ukrposhta = new UkrposhtaClass();
    $this->assertSame(Ukrposhta::VERSION, $ukrposhta->getVersion());
  }

  public function testGetEndpointUrlMethod(): void {
    $ukrposhta = new UkrposhtaClass();
    $this->assertSame(Ukrposhta::BASE_URL, $ukrposhta->getEndpointUrl());
  }

  public function testIsSandboxMethod(): void {
    $ukrposhta = new UkrposhtaClass();
    $this->assertFalse($ukrposhta->isSandbox());
    $ukrposhta = new UkrposhtaClass(sandbox: true);
    $this->assertTrue($ukrposhta->isSandbox());
  }

}
