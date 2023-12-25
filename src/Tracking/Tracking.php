<?php

declare(strict_types=1);

namespace Ukrposhta\Tracking;

use Exception;
use Psr\Log\LoggerInterface;
use Ukrposhta\Exceptions\NoCredentialException;
use Ukrposhta\Request\Request;
use Ukrposhta\Request\RequestInterface;
use Ukrposhta\Tracking\Entities\TrackingRoute;
use Ukrposhta\Tracking\Entities\TrackingRouteInterface;
use Ukrposhta\Tracking\Entities\TrackingStatus;
use Ukrposhta\Tracking\Entities\TrackingStatusCollection;
use Ukrposhta\Tracking\Entities\TrackingStatusCollectionInterface;
use Ukrposhta\Tracking\Entities\TrackingStatusInterface;
use Ukrposhta\Ukrposhta;

/**
 * Provides functionality to get Tracking Status information by barcode.
 */
class Tracking extends Ukrposhta implements TrackingInterface
{

    /** @var string Base endpoint to get status tracking information. */
    public const BASE_ENDPOINT = 'status-tracking';

    /** @var string Access type that needs to get status tracking information. */
    public const CREDENTIALS_TYPE = 'bearerStatusTracking';

    /** @var string Endpoint to get last tracking status information. */
    public const BARCODE_LAST_STATUS_ENDPOINT = '/statuses/last';
    /** @var string Endpoint to get all tracking statuses. */
    public const BARCODE_STATUSES_ENDPOINT = '/statuses';
    /** @var string Endpoint to get route information. */
    public const BARCODE_ROUTE_ENDPOINT = '/barcodes/%s/route';
    /** @var string Endpoint to get route information for specific language. */
    public const BARCODE_ROUTE_WITH_LANG_ENDPOINT = '/barcodes/%s/route/in-lang/%s';

    /**
     * Default language for requests.
     *
     * @var string
     */
    protected string $requestLang = 'UA';

    /**
     * Request object that uses in the class.
     *
     * @var RequestInterface|null
     */
    private ?RequestInterface $request = null;

    /**
     * Status Tracking access token that uses for requests.
     *
     * @var string|null
     */
    private ?string $accessToken = null;

    /**
     * {@inheritDoc}
     */
    public function __construct(
        string $bearerEcom = null,
        string $bearerStatusTracking = null,
        string $bearerCounterparty = null,
        bool $sandbox = false,
        LoggerInterface $logger = null,
        RequestInterface $request = null,
    ) {
        parent::__construct(
            $bearerEcom,
            $bearerStatusTracking,
            $bearerCounterparty,
            $sandbox,
            $logger
        );

        // Prepare request object.
        if (null !== $request) {
            $this->setRequest($request);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function requestBarcodeLastStatus(string $barcode): TrackingStatusInterface
    {
        $response = $this->getRequest()->request(
            $this->getAccessToken(),
            'GET',
            $this->getEndpointUrl() . self::BARCODE_LAST_STATUS_ENDPOINT,
            ['barcode' => $barcode, 'lang' => $this->getRequestLang()]
        );
        /** @var array<string, mixed> $response */
        $response = $response->getResponseData();

        return $this->convertTrackingStatusResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function requestBarcodeStatuses(string $barcode): TrackingStatusCollectionInterface
    {
        $response = $this->getRequest()->request(
            $this->getAccessToken(),
            'GET',
            $this->getEndpointUrl() . self::BARCODE_STATUSES_ENDPOINT,
            ['barcode' => $barcode, 'lang' => $this->getRequestLang()]
        );
        $response = $response->getResponseData();
        $collection = new TrackingStatusCollection();
        /** @var array<string, mixed> $trackingStatus */
        foreach ($response as $trackingStatus) {
            $collection->add($this->convertTrackingStatusResponse((array) $trackingStatus));
        }

        return $collection;
    }

    /**
     * {@inheritDoc}
     */
    public function requestBarcodeRoute(string $barcode, bool $en_version = false): TrackingRouteInterface
    {
        if (!$en_version) {
            $endpoint = sprintf(self::BARCODE_ROUTE_ENDPOINT, $barcode);
        } else {
            $endpoint = sprintf(self::BARCODE_ROUTE_WITH_LANG_ENDPOINT, $barcode, $this->getRequestLang());
        }
        $response = $this->getRequest()->request(
            $this->getAccessToken(),
            'GET',
            $this->getEndpointUrl() . $endpoint,
        );
        /** @var array<string, string> $response */
        $response = $response->getResponseData();

        return new TrackingRoute($response['from'], $response['to']);
    }

    /**
     * Helper function to converts Tracking Status response to the Tracking Status object.
     *
     * @param array<string|int, string|mixed> $trackingStatusResponseData
     *   Tracking Status response to process.
     *
     * @return TrackingStatusInterface
     *   Tracking Status object from the response data.
     *
     * @throws Exception
     */
    protected function convertTrackingStatusResponse(array $trackingStatusResponseData): TrackingStatusInterface
    {
        return new TrackingStatus(
            barcode: $trackingStatusResponseData['barcode'],
            step: (int) $trackingStatusResponseData['step'],
            date: new \DateTime($trackingStatusResponseData['date']),
            name: $trackingStatusResponseData['name'],
            eventId: (int) $trackingStatusResponseData['event'],
            eventName: $trackingStatusResponseData['eventName'],
            country: $trackingStatusResponseData['country'],
            mailType: (int) $trackingStatusResponseData['mailType'],
            indexOrder: (int) $trackingStatusResponseData['indexOrder'],
            index: $trackingStatusResponseData['index'],
            eventReason: $trackingStatusResponseData['eventReason'] ?? null,
            eventReasonId: $trackingStatusResponseData['eventReason_id'] ?? null
        );

    }

    /**
     * {@inheritDoc}
     */
    public function getEndpointUrl(): string
    {
        return self::BASE_URL . self::BASE_ENDPOINT . '/' . self::VERSION;
    }

    /**
     * Retrieves the request object.
     *
     * @return RequestInterface
     *   The request object.
     */
    public function getRequest(): RequestInterface
    {
        if (null === $this->request) {
            $this->request = new Request($this->getLogger());
        }

        return $this->request;
    }

    /**
     * Applies request object.
     *
     * @return $this
     */
    public function setRequest(RequestInterface $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Applies request language.
     *
     * @return $this
     */
    public function setRequestLang(string $lang): static
    {
        $this->requestLang = $lang;

        return $this;
    }

    /**
     * Gets request language.
     *
     * @return string
     */
    public function getRequestLang(): string
    {
        return $this->requestLang;
    }

    /**
     * Applies Tracking Status access token.
     *
     * @return $this
     */
    public function setAccessToken(string $bearerStatusTrackingAccessToken): static
    {
        $this->accessToken = $bearerStatusTrackingAccessToken;

        return $this;
    }

    /**
     * Gets Tracking Status access token.
     *
     * @return string
     */
    protected function getAccessToken(): string
    {
        if (!$this->accessToken) {
            if (!$this->{static::CREDENTIALS_TYPE}) {
                throw new NoCredentialException(sprintf('The %s token is required.', static::CREDENTIALS_TYPE));
            } else {
                $this->setAccessToken($this->{static::CREDENTIALS_TYPE});
            }
        }
        // todo: fix phpstan error with return type.
        /** @phpstan-ignore-next-line */
        return $this->accessToken;
    }

}
