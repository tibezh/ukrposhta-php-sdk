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
* [Requirements](#-requirements)
* [Available Features](#-available-features)
* [Installation](#-installation)
* [Examples](#-examples)
  * [Status Tracking](#-status-tracking)


<a name="requirements"></a>
### Requirements
This library uses PHP 8.1+.

To use the Ukrposhta API, you need to have Bearer and Token for each API sub-portal (eCom, StatusTracking and AddressClassifier).
After signing the contract, the bearer and token are issued by your manager.
You can find more information [here](https://dev.ukrposhta.ua/for-business).


<a name="available-features"></a>
### Available Features
* Status Tracking - available.
* Address Classifier (counterparty) - _planned_.
* Shipments - _planned_.


<a name="installation"></a>
### Installation
To get started, simply require the project using [Composer](https://getcomposer.org/).

```bash
composer require tibezh/ukrposhta-php-sdk
```


<a name="examples"></a>
### Examples

<a name="status-tracking"></a>
#### Status Tracking

Request last status by barcode:
```php
/** @var \Ukrposhta\Tracking\TrackingStatusInterface $barcodeLastStatus */
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
/** @var \Ukrposhta\Tracking\TrackingStatusCollectionInterface $barcodeLastStatuses */
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
/** @var \Ukrposhta\Tracking\TrackingRouteInterface $barcodeRoute */
$barcodeRoute = (new \Ukrposhta\Tracking\Tracking())
  ->setAccessToken('[BEARER-STATUS-TRACKING-ACCESS-TOKEN]')
  // To get results in English.
  // ->$this->setRequestLang('EN')
  ->requestBarcodeRoute('[BARCODE]');
// Prints "[from] -> [to]" information for the given barcode.
print $barcodeRoute->getFrom() ' -> ' . $barcodeRoute->getTo();
```

[Ukrposhta API]: https://dev.ukrposhta.ua/documentation "Ukrposhta API"
