# Lulu Provider for OAuth 2.0 Client

This package provides Lulu OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

```
composer require westerncpe/lulu-php-client-api
```

## Usage

```php
if( ! defined('LULU_API_URL') ){
    define('LULU_API_URL', 'https://api.lulu.com');
}

if( ! defined('LULU_CLIENT_ID') ){
    define('LULU_CLIENT_ID', 'f2a1ed52710d4533bde25be6da03b6e3');
}

if( ! defined('LULU_CLIENT_SECRET') ){
    define('LULU_CLIENT_SECRET', '269d98e4922fb3895e9ae2108cbb5064');
}

$luluProvider = new \WesternCPE\OAuth2\Client\Provider\Lulu([
    'clientId'                => LULU_CLIENT_ID,          // The client ID assigned to you by Lulu
    'clientSecret'            => LULU_CLIENT_SECRET,      // The client password assigned to you by Lulu
]);

try {

    // Try to get an access token using the client credentials grant.
    $token = $luluProvider->getAccessToken( 'client_credentials' );

    $method = 'GET';
	$url    = 'https://api.lulu.com/print-jobs/';

    $authenticatedRequest = $luluProvider->getAuthenticatedRequest( $method, $url, $token );


} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

    // Failed to get the access token
    exit($e->getMessage());

}


```

For more information see the PHP League's general usage examples.

## Testing

```bash
$ ./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/michaelKaefer/oauth2-amazon/blob/master/LICENSE) for more information.
