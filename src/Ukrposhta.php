<?php declare(strict_types=1);

namespace Ukrposhta;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * The main abstract class to Ukrposhta connection.
 */
abstract class Ukrposhta implements LoggerAwareInterface {

  public const VERSION = '0.0.1';
  public const BASE_URL = 'https://www.ukrposhta.ua/';

  /**
   * @param string|null $bearerEcom
   * @param string|null $bearerStatusTracking
   * @param string|null $bearerCounterparty
   * @param bool $sandbox
   * @param LoggerInterface|null $logger
   */
  public function __construct(
    protected readonly ?string $bearerEcom = null,
    protected readonly ?string $bearerStatusTracking = null,
    protected readonly ?string $bearerCounterparty = null,
    protected bool $sandbox = false,
    protected ?LoggerInterface $logger = null,
  ) {

  }

  /**
   * @param LoggerInterface $logger
   */
  public function setLogger(LoggerInterface $logger): void {
    $this->logger = $logger;
  }

  /**
   * @return LoggerInterface|null
   */
  public function getLogger(): ?LoggerInterface {
    return $this->logger;
  }

  /**
   * Gets endpoints URL.
   *
   * @return string|null
   */
  protected function getEndpointUrl(): ?string {
    return self::BASE_URL;
  }

  /**
   * @return bool
   */
  protected function isSandbox(): bool {
    return $this->sandbox;
  }

}
