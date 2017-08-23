# CoinMarketCap PHP Wrapper

PHP wrapper class for CoinMarketCap, built on top of [HttpFull](https://github.com/nategood/httpful).

## Requirements

* PHP 5.3+
* [Composer](https://getcomposer.org/)
* [HTTPFUL](https://github.com/nategood/httpful) (downloaded automatically by Composer)

## Installation

`composer require daycry/coinmarketcap`

## Usage

```
<?php

require __DIR__ . '/vendor/autoload.php';

use CoinMarketCap\Base;

$coinmarketcap = new Base();

// Get ticker
$coinmarketcap->getTicker();

// Get ticker by coin
$coin = 'bitcoin';
$coinmarketcap->getTickerByCoin($coin);

// Get global data
$coinmarketcap->getGlobalData();
```

See the [API documentation](https://coinmarketcap.com/api/) for more information about the endpoints and responses.
