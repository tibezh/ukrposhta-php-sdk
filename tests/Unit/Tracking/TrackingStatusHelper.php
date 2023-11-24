<?php declare(strict_types=1);

namespace Ukrposhta\Tests\Unit\Tracking;

use Ukrposhta\Tests\Utils\FakerFactory;

/**
 *
 */
class TrackingStatusHelper {

  public static function getRandomTrackingStatusFixture(): array {
    $fixture = [];
    $faker_generator = FakerFactory::create();
    $keys_mapping = [
      'barcode' => 'barcode',
      'step' => 'randomDigit',
      'date' => 'dateTime',
      'name' => ['sentence', 3],
      'eventId' => 'randomDigit',
      'eventName' => ['sentence', 3],
      'country' => 'country',
      'eventReason' => 'sentenceOrNull',
      'eventReasonId' => 'randomDigitOrNull',
      'mailType' => 'randomDigit',
      'indexOrder' => 'randomDigit',
      'index' => 'randomStringOrNull',
    ];
    foreach ($keys_mapping as $key => $func) {
      if (is_array($func)) {
        $fixture[$key] = $faker_generator->{$func[0]}($func[1]);
      }
      else {
        $fixture[$key] = $faker_generator->{$func}();
      }
    }
    return $fixture;
  }

  public static function getRandomTrackingStatusResponseDataFixture(): array {
    $fixture = [];
    $faker_generator = FakerFactory::create();
    $keys_mapping = [
      'barcode' => 'barcode',
      'step' => 'randomDigit',
      'date' => 'dateTime',
      'name' => ['sentence', 3],
      'event' => 'randomDigit',
      'eventName' => ['sentence', 3],
      'country' => 'country',
      'mailType' => 'randomDigit',
      'indexOrder' => 'randomDigit',
      'index' => 'randomStringOrNull',
      'eventReason' => 'sentenceOrNull',
      'eventReason_id' => 'randomDigitOrNull',
    ];
    foreach ($keys_mapping as $key => $func) {
      if (is_array($func)) {
        $fixture[$key] = $faker_generator->{$func[0]}($func[1]);
      }
      else {
        $fixture[$key] = $faker_generator->{$func}();
      }
    }
    $fixture['date'] = $fixture['date']->format('c');
    return $fixture;
  }

}
