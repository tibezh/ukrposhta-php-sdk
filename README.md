<h1 align="center">Ukrpostha PHP SDK</h1>
<p align="center">
    <img src="https://raw.githubusercontent.com/tibezh/ukrposhta-php-sdk/master/doc/assets/ukrpostha_logo.svg" title="Ukrposhta PHP SDK" alt="Ukrposhta PHP SDK logo">
</p>

An Ukrposhta PHP SDK based on the official [Ukrposhta API].

<p align="center">

[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D8.1-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](https://github.com/tibezh/ukrposhta-php-sdk/blob/master/LICENSE)
[![CI](https://github.com/tibezh/ukrposhta-php-sdk/actions/workflows/ci.yml/badge.svg)](https://github.com/tibezh/ukrposhta-php-sdk/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/tibezh/ukrposhta-php-sdk/graph/badge.svg?token=PPRCRB96LZ)](https://codecov.io/gh/tibezh/ukrposhta-php-sdk)
[![Latest Stable Version](https://img.shields.io/packagist/v/tibezh/ukrposhta-php-sdk.svg)](https://packagist.org/packages/tibezh/ukrposhta-php-sdk)

</p>

## Table of Contents
* [Requirements](#requirements)
* [Available Features](#available-features)
* [Installation](#installation)
* [Configuration](#configuration)
  * [Retry Configuration](#retry-configuration)
  * [Logging](#logging)
* [Examples](#examples)
  * [Status Tracking](#status-tracking)
  * [Address Classifier](#address-classifier)
* [Working with Collections](#working-with-collections)


<a name="requirements"></a>
### Requirements
This library uses PHP 8.1+.

To use the Ukrposhta API, you need to have Bearer and Token for each API sub-portal (eCom, StatusTracking and AddressClassifier).
After signing the contract, the bearer and token are issued by your manager.
You can find more information [here](https://dev.ukrposhta.ua/for-business).


<a name="available-features"></a>
### Available Features
* Status Tracking - available.
* Address Classifier (counterparty) - available.
* Shipments - _planned_.


<a name="installation"></a>
### Installation
To get started, simply require the project using [Composer](https://getcomposer.org/).

```bash
composer require tibezh/ukrposhta-php-sdk
```


<a name="configuration"></a>
### Configuration

<a name="retry-configuration"></a>
#### Retry Configuration

The SDK includes automatic retry logic for transient network errors (connection timeouts, DNS failures, etc.) with exponential backoff and jitter.

Default settings:
- **Max retries:** 3 attempts
- **Base delay:** 100ms (with exponential backoff: 100ms, 200ms, 400ms...)

You can customize retry behavior when creating a custom Request object:

```php
use Ukrposhta\Request\Request;
use Ukrposhta\Tracking\Tracking;

// Create a custom request with retry settings.
$request = new Request(
    logger: null,       // Optional PSR-3 logger
    maxRetries: 5,      // Max retry attempts (default: 3)
    retryDelayMs: 200   // Base delay in milliseconds (default: 100)
);

// Use the custom request with Tracking.
$tracking = new Tracking(
    bearerStatusTracking: '[BEARER-TOKEN]',
    request: $request
);
```

To disable retries, set `maxRetries` to 0:

```php
$request = new Request(logger: null, maxRetries: 0);
```

<a name="logging"></a>
#### Logging

The SDK supports PSR-3 logging. Pass any PSR-3 compatible logger to track API requests and responses:

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ukrposhta\Tracking\Tracking;

$logger = new Logger('ukrposhta');
$logger->pushHandler(new StreamHandler('path/to/ukrposhta.log', Logger::DEBUG));

$tracking = new Tracking(
    bearerStatusTracking: '[BEARER-TOKEN]',
    logger: $logger
);
```


<a name="examples"></a>
### Examples

<a name="status-tracking"></a>
#### Status Tracking

Request last status by barcode:

```php
/** @var \Ukrposhta\Tracking\Entities\TrackingStatusInterface $barcodeLastStatus */
$barcodeLastStatus = (new \Ukrposhta\Tracking\Tracking())
  ->setAccessToken('[BEARER-STATUS-TRACKING-ACCESS-TOKEN]')
  // To get results in English.
  // ->$this->setRequestLang('EN')
  ->requestBarcodeLastStatus('[BARCODE]');

// Prints event name value of the last status for the given barcode.
print $barcodeLastStatus->getEventName();
```

Request all statuses by barcode:

```php
/** @var \Ukrposhta\Tracking\Entities\TrackingStatusCollectionInterface $barcodeLastStatuses */
$barcodeLastStatuses = (new \Ukrposhta\Tracking\Tracking())
  ->setAccessToken('[BEARER-STATUS-TRACKING-ACCESS-TOKEN]')
  // To get results in English.
  // ->$this->setRequestLang('EN')
  ->requestBarcodeStatuses('[BARCODE]');

// Prints "[date]: [eventName]" of each status for the given barcode.
foreach ($data->all() as $item) {
  print $item->getDate()->format('c') . ': ' . $item->getEventName();
  print '<br>';
}
```

Request route by barcode:

```php
/** @var \Ukrposhta\Tracking\Entities\TrackingRouteInterface $barcodeRoute */
$barcodeRoute = (new \Ukrposhta\Tracking\Tracking())
  ->setAccessToken('[BEARER-STATUS-TRACKING-ACCESS-TOKEN]')
  // To get results in English.
  // ->$this->setRequestLang('EN')
  ->requestBarcodeRoute('[BARCODE]');
// Prints "[from] -> [to]" information for the given barcode.
print $barcodeRoute->getFrom() . ' -> ' . $barcodeRoute->getTo();
```

<a name="address-classifier"></a>
#### Address Classifier

The Address Classifier API allows you to search regions, districts, cities, streets, post offices and more.

Request regions:

```php
use Ukrposhta\AddressClassifier\AddressClassifier;
use Ukrposhta\Utilities\Languages\LanguagesEnum;

$classifier = new AddressClassifier(
    bearerCounterparty: '[BEARER-COUNTERPARTY-ACCESS-TOKEN]'
);

/** @var \Ukrposhta\AddressClassifier\Entities\Region\RegionCollectionInterface $regions */
$regions = $classifier->requestRegions('Київ');

foreach ($regions->all() as $region) {
    print $region->getId() . ': ' . $region->getName();
    print '<br>';
}
```

Request districts by region ID:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\District\DistrictCollectionInterface $districts */
$districts = $classifier->requestDistrictsByRegionId(regionId: 1);

foreach ($districts->all() as $district) {
    print $district->getId() . ': ' . $district->getName();
    print '<br>';
}
```

Request cities by region ID and district ID:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\City\CityCollectionInterface $cities */
$cities = $classifier->requestCityByRegionIdAndDistrictId(
    regionId: 1,
    districtId: 5,
    cityName: 'Бориспіль'
);

foreach ($cities->all() as $city) {
    print $city->getId() . ': ' . $city->getName()->getByLanguage(LanguagesEnum::UA);
    print '<br>';
}
```

Request streets by city ID:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\Street\StreetCollectionInterface $streets */
$streets = $classifier->requestStreetByRegionIdAndDistrictIdAndCityId(
    regionId: 1,
    districtId: 5,
    cityId: 100,
    streetName: 'Головна'
);

foreach ($streets->all() as $street) {
    print $street->getId() . ': ' . $street->getName()->getByLanguage(LanguagesEnum::UA);
    print '<br>';
}
```

Request post offices by city ID:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\PostOffice\PostOfficeCollectionInterface $postOffices */
$postOffices = $classifier->requestPostOfficeByCityId(cityId: 100);

foreach ($postOffices->all() as $postOffice) {
    print $postOffice->getPostIndex() . ': ' . $postOffice->getName()->getByLanguage(LanguagesEnum::UA);
    print '<br>';
}
```

Request nearest post offices by geolocation:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\NearestPostOffice\NearestPostOfficeCollectionInterface $nearestPostOffices */
$nearestPostOffices = $classifier->requestNearestPostOffices(
    latitude: 50.4501,
    longitude: 30.5234,
    maxDistance: 1000 // meters
);

foreach ($nearestPostOffices->all() as $postOffice) {
    print $postOffice->getFilialName() . ' - ' . $postOffice->getDistance() . ' m';
    print '<br>';
}
```

Fuzzy search for cities:

```php
/** @var \Ukrposhta\AddressClassifier\Entities\CitySearchItem\CitySearchItemCollectionInterface $cities */
$cities = $classifier->requestSearchCity(
    regionId: 1,
    districtId: 5,
    cityName: 'Борис', // partial name
    language: LanguagesEnum::UA,
    fuzzy: true
);

foreach ($cities->all() as $city) {
    print $city->getName() . ' (' . $city->getTypeName() . ')';
    print '<br>';
}
```


<a name="working-with-collections"></a>
### Working with Collections

All collection classes implement `Countable` and `IteratorAggregate`/`Iterator` interfaces, allowing you to:

```php
// Get count of items.
$count = count($regions);
// Or use the count() method.
$count = $regions->count();

// Check if collection is empty.
if ($regions->isEmpty()) {
    echo 'No regions found';
}

// Iterate directly with foreach.
foreach ($regions as $region) {
    echo $region->getName();
}

// Get all items as array.
$allRegions = $regions->all();
```

[Ukrposhta API]: https://dev.ukrposhta.ua/documentation "Ukrposhta API"
