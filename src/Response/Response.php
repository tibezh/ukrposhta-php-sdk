<?php declare(strict_types=1);

namespace Ukrposhta\Response;

/**
 *
 */
class Response implements ResponseInterface {

  public function __construct(protected readonly array $response = []) {

  }

  /**
   * {@inheritDoc}
   */
  public function getResponseData(): array {
    return $this->response;
  }

}

