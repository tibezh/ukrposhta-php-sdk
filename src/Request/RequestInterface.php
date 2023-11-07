<?php declare(strict_types=1);

namespace Ukrposhta\Request;

use Psr\Log\LoggerInterface;
use Ukrposhta\Response\ResponseInterface;

/**
 *
 */
interface RequestInterface {

  /**
   * @param LoggerInterface|null $logger
   */
  public function __construct(?LoggerInterface $logger = null);

  /**
   * @param string $access
   * @param string $method
   * @param string $endpointUrl
   * @param array $request
   * @return ResponseInterface
   */
  public function request(string $access, string $method, string $endpointUrl, array $request = []): ResponseInterface;

  /**
   * @param $access
   */
  public function setAccess($access): static;

  /**
   * @return string
   */
  public function getAccess(): string;

  /**
   * @param array $request
   */
  public function setRequest(array $request): static;

  /**
   * @return string
   */
  public function getRequest(): array;

  /**
   * @param $endpointUrl
   */
  public function setEndpointUrl($endpointUrl): static;

  /**
   * @return string
   */
  public function getEndpointUrl(): string;
}
