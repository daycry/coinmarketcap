# CoinMarketCap PHP Wrapper

PHP wrapper class for CoinMarketCap, built on top of [HttpFull](https://github.com/nategood/httpful).

## Requirements

* PHP 7
* [Composer](https://getcomposer.org/)
* [HTTPFUL](https://github.com/nategood/httpful) (downloaded automatically by Composer)

## Installation

`composer require daycry/coinmarketcap`

## Usage

```
<?php

require __DIR__ . '/vendor/autoload.php';

use CoinMarketCap\Base;

$coinmarketcap = new Coinmarketcap( 'key' );

// Get ticker
$coinmarketcap->getLatest();

// Get global data
$coinmarketcap->getGlobal();
```

See the [API documentation](https://coinmarketcap.com/api/documentation/v1) for more information about the endpoints and responses.
