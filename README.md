# Lulu Provider for OAuth 2.0 Client

This package provides Lulu OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

```
composer require westerncpe/lulu-php-client-api
```

## Usage

```php
$luluProvider = new \WesternCPE\OAuth2\Client\Provider\Lulu([
    'clientId'                => 'yourId',          // The client ID assigned to you by Lulu
    'clientSecret'            => 'yourSecret',      // The client password assigned to you by Lulu
]);


```

For more information see the PHP League's general usage examples.

## Testing

```bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/michaelKaefer/oauth2-amazon/blob/master/LICENSE) for more information.
