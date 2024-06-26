<?php

namespace WesternCPE\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;

class Lulu extends AbstractProvider {

	use BearerAuthorizationTrait;

	// const LULU_API_URL = 'https://api.lulu.com';

	/**
	 * @var array List of scopes that will be used for authentication.
	 *
	 * Valid scopes: phone, email, openid, aws.cognito.signin.user.admin, profile
	 * Defaults to email, openid
	 *
	 */
	protected $scopes = array();

	/**
	 * @return array
	 */
	public function getScopes() {
		return $this->scopes;
	}

	/**
	 * Get authorization url to begin OAuth flow
	 *
	 * @return string
	 */
	public function getBaseAuthorizationUrl() {
		return LULU_API_URL . '/ap/oa';
	}

	/**
	 * Get access token url to retrieve token
	 *
	 * @param array $params
	 *
	 * @return string
	 */
	public function getBaseAccessTokenUrl( array $params ) {
		return LULU_API_URL . '/auth/realms/glasstree/protocol/openid-connect/token';
	}

	/**
	 * Get provider url to fetch user details
	 *
	 * @param AccessToken $token
	 *
	 * @return string
	 */
	public function getResourceOwnerDetailsUrl( AccessToken $token ) {
		return LULU_API_URL . '/user/profile';
	}

	/**
	 * Get the default scopes used by this provider.
	 *
	 * @return array
	 */
	protected function getDefaultScopes() {
		return array( 'client_credentials' );
	}

	/**
	 * Returns the string that should be used to separate scopes when building
	 * the URL for requesting an access token.
	 *
	 * @return string Scope separator, defaults to ','
	 */
	protected function getScopeSeparator() {
		return ' ';
	}

	/**
	 * Check a provider response for errors.
	 *
	 * @param  ResponseInterface $response
	 * @param  array|string $data
	 *
	 * @throws IdentityProviderException
	 */
	protected function checkResponse( ResponseInterface $response, $data ) {
		if ( 200 !== $response->getStatusCode() ) {
			$statusCode = $response->getStatusCode();
			$error      = $data;
			throw new IdentityProviderException(
				$statusCode . ' - ' . json_encode( $error ),
				$response->getStatusCode(),
				$response
			);
		}
	}

	/**
	 * Generate a user object from a successful user details request.
	 *
	 * @param array $response
	 * @param AccessToken $token
	 *
	 * @return League\OAuth2\Client\Provider\ResourceOwnerInterface
	 */
	protected function createResourceOwner( array $response, AccessToken $token ) {
		// return new AmazonResourceOwner( $response );
	}

	/**
	 * Returns a prepared request for requesting an access token.
	 *
	 * @param array $params
	 *
	 * @return Psr\Http\Message\RequestInterface
	 */
	protected function getAccessTokenRequest( array $params ) {
		$request = parent::getAccessTokenRequest( $params );
		$uri     = $request->getUri()
		->withUserInfo( $this->clientId, $this->clientSecret );
		return $request->withUri( $uri );
	}
}

/*
namespace LemonStand\OAuth2\Client\Provider;
use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
class Amazon extends AbstractProvider
{
	public $scopeSeparator = ' ';
	public $testMode = false;
	public $scopes = ['profile','payments:widget','payments:shipping_address'];
	public function __construct($options = [])
	{
		parent::__construct($options);
		if (isset($options['testMode'])) {
			$this->testMode = $options['testMode'];
		}
	}
	public function urlAuthorize()
	{
		return 'https://www.amazon.com/ap/oa';
	}
	public function urlAccessToken()
	{
		return ($this->testMode) ? 'https://api.sandbox.amazon.com/auth/o2/token' : 'https://api.amazon.com/auth/o2/token';
	}
	public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
	{
		$url = ($this->testMode) ? 'https://api.sandbox.amazon.com/user/profile' : 'https://api.amazon.com/user/profile';
		return $url . '?access_token=' . $token;
	}
	public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		$user = new User();
		$user->exchangeArray([
			'uid'   => isset($response->user_id) ? $response->user_id : null,
			'name'  => isset($response->name) ? $response->name : null,
			'email' => isset($response->email) ? $response->email : null
		]);
		return $user;
	}
	public function userUid($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		return isset($response->user_id) ? $response->user_id : null;
	}
	public function getAuthorizationUrl($options = [])
	{
		$url = parent::getAuthorizationUrl($options);
		if ($this->testMode) {
			$url .= '&sandbox=true';
		}
		return $url;
	}
}
 */
