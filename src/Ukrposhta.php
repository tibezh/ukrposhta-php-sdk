<?php

declare(strict_types=1);

namespace Ukrposhta;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

/**
 * The main abstract class to Ukrposhta connection.
 */
abstract class Ukrposhta implements LoggerAwareInterface {

  const VERSION = '0.0.1';
  const BASE_URL = 'https://ukrposhta.ua/ecom';

  protected string $accessBearer;

  protected string $accessToken;

  protected LoggerInterface $logger;

  /**
   * Constructor.
   *
   * @param string|null $bearer
   * @param string|null $token
   * @param LoggerInterface|null $logger
   */
  public function __construct(string $bearer = null, string $token = null, LoggerInterface $logger = null) {
    $this->accessBearer = $bearer;
    $this->accessToken = $token;
    $this->logger = $logger;
  }

  /**
   * @param LoggerInterface $logger
   */
  public function setLogger(LoggerInterface $logger): void {
    $this->logger = $logger;
  }

  /**
   * @return LoggerInterface
   */
  public function getLogger(): LoggerInterface {
    return $this->logger;
  }

  /**
   * Gets endpoints URL.
   *
   * @return string
   */
  protected function getEndpointUrl(): string {
    return self::BASE_URL . '/' . self::VERSION;
  }


}
