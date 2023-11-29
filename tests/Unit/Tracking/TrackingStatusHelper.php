<?php

declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use DateTime;

class TrackingStatusHelper
{
    /**
     * @return array<string, mixed>
     */
    public static function getRandomTrackingStatusFixture(): array
    {
        return [
          'barcode' => '123',
          'step' => 0,
          'date' => new DateTime('January 11 2023'),
          'name' => 'random tracking status fixture',
          'eventId' => 321,
          'eventName' => 'random tracking status event name',
          'country' => 'Ukraine status fixture',
          'eventReason' => null,
          'eventReasonId' => null,
          'mailType' => 563,
          'indexOrder' => 4789,
          'index' => '32123',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function getRandomTrackingStatusResponseDataFixture(): array
    {
        return [
          'barcode' => '456',
          'step' => 1,
          'date' => (new DateTime('August 23 2023'))->format('c'),
          'name' => 'random tracking status response data fixture',
          'event' => 654,
          'eventName' => 'random tracking status response event name',
          'country' => 'Ukraine response status fixture',
          'mailType' => 890,
          'indexOrder' => 1235,
          'index' => null,
          'eventReason' => null,
          'eventReason_id' => 1579,
        ];
    }
}
