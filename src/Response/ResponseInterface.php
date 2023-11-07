<?php declare(strict_types=1);

namespace Ukrposhta\Response;

interface ResponseInterface {

  /**
   * Response object.
   *
   * @return array
   */
  public function getResponseData(): array;

}
