# Enable/disable query logger in Laravel/Lumen
[![StyleCI](https://github.styleci.io/repos/477752604/shield?branch=master)](https://github.styleci.io/repos/477752604?branch=master)
[![CircleCI](https://circleci.com/gh/pnlinh/laravel-query-logger/tree/master.svg?style=svg)](https://circleci.com/gh/pnlinh/laravel-query-logger/tree/master)

## Requirements

- PHP >= 7.1.3
- Laravel >= 5.5.*

## Installation

Require this package with composer.

```bash
composer require pnlinh/laravel-query-logger
```

## Usage

To enable log query, set .env file below
```
APP_DEBUG=true
```

To disable log query, set .env file below
```
APP_DEBUG=false
```

## Test

```bash
composer test
```

## Credits

- [Ngoc Linh Pham](https://github.com/pnlinh)
