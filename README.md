# Enable/disable query logger in Laravel/Lumen

[![StyleCI](https://github.styleci.io/repos/477752604/shield?branch=master)](https://github.styleci.io/repos/477752604?branch=master)
[![CircleCI](https://circleci.com/gh/pnlinh/laravel-query-logger/tree/master.svg?style=svg)](https://circleci.com/gh/pnlinh/laravel-query-logger/tree/master)
[![Quality Score](https://img.shields.io/scrutinizer/quality/g/pnlinh/laravel-query-logger.svg?style=flat-square)](https://scrutinizer-ci.com/g/pnlinh/laravel-query-logger/)

## Requirements

- PHP >= 7.1.3
- Laravel >= 5.5.*

## Installation

Require this package with composer.

```bash
composer require pnlinh/laravel-query-logger --dev
```

To publishes config `config/query-logger.php`, use command:

```shell
php artisan vendor:publish --tag="query-logger"
```

## Usage

To enable log query, set .env file below

```
QUERY_LOGGER_ENABLED=true
```

To disable log query, set .env file below

```
QUERY_LOGGER_ENABLED=false
```

## Test

- Without Docker

```bash
composer test
```

- With Docker

```bash
make test
```

## Credits

- [Ngoc Linh Pham](https://github.com/pnlinh)
