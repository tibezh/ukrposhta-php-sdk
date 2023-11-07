<?php declare(strict_types=1);

namespace Ukrposhta\Tracking;

use Psr\Log\LoggerInterface;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Ukrposhta;

class Tracking extends Ukrposhta implements TrackingInterface {

  public const BASE_ENDPOINT = 'status-tracking';

  public const CREDENTIALS_TYPE = 'bearerStatusTracking';

  public const BARCODE_LAST_STATUS_ENDPOINT = '/statuses/last';
  public const BARCODE_STATUSES_ENDPOINT = '/statuses';
  public const BARCODE_ROUTE_ENDPOINT = '/barcodes/%s/route';
  public const BARCODE_ROUTE_WITH_LANG_ENDPOINT = '/barcodes/%s/route/in-lang/%s';

  /**
   * @var string
   */
  protected string $requestLang = 'UA';

  /**
   * @var RequestInterface|null
   */
  private ?RequestInterface $request = null;

  /**
   * @var string|null
   */
  private ?string $accessToken = null;

  public function __construct(
    ?string $bearerEcom = null,
    ?string $bearerStatusTracking = null,
    ?string $bearerCounterparty = null,
    bool $sandbox = false,
    ?LoggerInterface $logger = null,
    ?RequestInterface $request = null,
  ) {
    parent::__construct(
      $bearerEcom,
      $bearerStatusTracking,
      $bearerCounterparty,
    $sandbox,
      $logger
    );

    // Prepare request object.
    if (null !== $this->request) {
      $this->setRequest($request);
    }
  }

  /**
   * {@inheritDoc}
   */
  public function requestBarcodeLastStatus(string $barcode): TrackingStatusInterface {
    $response = $this->getRequest()->request(
      $this->getAccessToken(),
      'GET',
      $this->getEndpointUrl() . self::BARCODE_LAST_STATUS_ENDPOINT,
      ['barcode' => $barcode, 'lang' => $this->getRequestLang()]
    );
    $response = $response->getResponseData();
    return $this->convertTrackingStatusResponse($response);
  }

  /**
   * {@inheritDoc}
   */
  public function requestBarcodeStatuses(string $barcode): TrackingStatusCollectionInterface {
    $response = $this->getRequest()->request(
      $this->getAccessToken(),
      'GET',
      $this->getEndpointUrl() . self::BARCODE_STATUSES_ENDPOINT,
      ['barcode' => $barcode, 'lang' => $this->getRequestLang()]
    );
    $response = $response->getResponseData();
    $collection = new TrackingStatusCollection();
    foreach ($response as $trackingStatus) {
      $collection->add($this->convertTrackingStatusResponse($trackingStatus));
    }
    return $collection;
  }

  /**
   * {@inheritDoc}
   */
  public function requestBarcodeRoute(string $barcode, bool $en_version = FALSE): TrackingRouteInterface {
    if (!$en_version) {
      $endpoint = sprintf(self::BARCODE_ROUTE_ENDPOINT, $barcode);
    }
    else {
      $endpoint = sprintf(self::BARCODE_ROUTE_WITH_LANG_ENDPOINT, $barcode, $this->getRequestLang());
    }
    $response = $this->getRequest()->request(
      $this->getAccessToken(),
      'GET',
      $this->getEndpointUrl() . $endpoint,
    );
    $response = $response->getResponseData();
    return new TrackingRoute($response['from'], $response['to']);
  }

  /**
   * @param array $trackingStatusResponseData
   * @return TrackingStatusInterface
   * @throws \Exception
   */
  protected function convertTrackingStatusResponse(array $trackingStatusResponseData): TrackingStatusInterface {
    return new TrackingStatus(
      barcode: $trackingStatusResponseData['barcode'],
      step: (int) $trackingStatusResponseData['step'],
      date: new \DateTime($trackingStatusResponseData['date']),
      index: $trackingStatusResponseData['index'],
      eventId: (int) $trackingStatusResponseData['event'],
      eventName: $trackingStatusResponseData['eventName'],
      country: $trackingStatusResponseData['country'],
      eventReason: $trackingStatusResponseData['eventReason'] ?? null,
      eventReasonId: $trackingStatusResponseData['eventReason_id'] ? (int) $trackingStatusResponseData['eventReason_id'] : null,
      mailType: (int) $trackingStatusResponseData['mailType'],
      indexOrder: (int) $trackingStatusResponseData['indexOrder']
    );
  }

  /**
   * {@inheritDoc}
   */
  protected function getEndpointUrl(): string {
    return self::BASE_URL . self::BASE_ENDPOINT . '/' . self::VERSION;
  }

  /**
   * @return RequestInterface
   */
  public function getRequest(): RequestInterface {
    if (null === $this->request) {
      $this->request = new Request($this->getLogger());
    }
    return $this->request;
  }

  /**
   * @param RequestInterface $request
   * @return $this
   */
  public function setRequest(RequestInterface $request): static {
    $this->request = $request;
    return $this;
  }

  /**
   * @param string $lang
   * @return $this
   */
  public function setRequestLang(string $lang): static {
    $this->requestLang = $lang;
    return $this;
  }

  /**
   * @return string
   */
  public function getRequestLang(): string {
    return $this->requestLang;
  }

  /**
   * @param string $bearerStatusTrackingAccessToken
   * @return $this
   */
  public function setAccessToken(string $bearerStatusTrackingAccessToken): static {
    $this->accessToken = $bearerStatusTrackingAccessToken;
    return $this;
  }

  /**
   * @return string
   */
  protected function getAccessToken(): string {
    if (!$this->accessToken) {
      if (!$this->{static::CREDENTIALS_TYPE}) {
        throw new NoCredentialException(sprintf('The %s token is required.', static::CREDENTIALS_TYPE));
      }
      else {
        $this->setAccessToken($this->{static::CREDENTIALS_TYPE});
      }
    }
    return $this->accessToken;
  }

}
