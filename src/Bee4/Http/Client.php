<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http
 */

namespace Bee4\Http;

use Bee4\Http\Message\Request\AbstractRequest;
use Bee4\Http\Message\RequestFactory;
use Bee4\Http\Message\ResponseFactory;

/**
 * Http client
 * @package Bee4\Http
 */
class Client {
	/**
	 * Base URL for calls
	 * @var string
	 */
	protected $baseUrl;

	/**
	 * Handle collection to be used to prevent bind problem
	 * @var array
	 */
	protected static $handles = [];

	/**
	 * HTTP Client which use cURL extension
	 * @param string $baseUrl Base URL of the web service
	 */
	public function __construct($baseUrl = '') {
		if (!extension_loaded('curl')) {
			throw new \RuntimeException('The PHP cURL extension must be installed!');
		}

    $this->baseUrl = $baseUrl;
    $this->requestFactory = new RequestFactory();
	}

	/**
	 * HTTP Get wrapper
	 * @param string $url
	 * @param array $headers
	 */
	public function get($url = '', array $headers = []) {
		return $this->createRequest('GET', $this->baseUrl.$url, $headers);
	}

	/**
	 * HTTP HEAD wrapper
	 * @param string $url
	 * @param array $headers
	 */
	public function head($url = '', array $headers = []) {
		return $this->createRequest('HEAD', $this->baseUrl.$url, $headers);
	}

	/**
	 * HTTP POST wrapper
	 * @param string $url
	 * @param array $headers
	 */
	public function post($url = '', array $headers = []) {
		return $this->createRequest('POST', $this->baseUrl.$url, $headers);
	}

	/**
	 * HTTP PUT wrapper
	 * @param string $url
	 * @param array $headers
	 */
	public function put($url = '', array $headers = []) {
		return $this->createRequest('PUT', $this->baseUrl.$url, $headers);
	}

	/**
	 * HTTP DELETE wrapper
	 * @param string $url
	 * @param array $headers
	 */
	public function delete($url = '', array $headers = []) {
		return $this->createRequest('DELETE', $this->baseUrl.$url, $headers);
	}

	/**
	 * Create the request object
	 * @param string $method
	 * @param string $url
	 * @param array $headers
	 * @return AbstractRequest
	 */
	protected function createRequest( $method, $url, array $headers = [] ) {
		if( !is_string($url) || trim($url) === "" || parse_url($url) === false ) {
			throw new \InvalidArgumentException('URL given must be a valid URL');
		}

		$request = $this->requestFactory->build($method, $url, $headers);
		$request->setClient($this);

		return $request;
	}

	/**
	 * Send the request
	 * @param Request $request The request to be send
	 * @return Bee4\Http\Message\Response
	 */
	public function send( AbstractRequest $request ) {
		if( !isset(self::$handles[get_class($request)]) ) {
			self::$handles[get_class($request)] = new Curl\Handle();
		}

		self::$handles[get_class($request)]->addOptions($request->getCurlOptions());
		self::$handles[get_class($request)]->addOption(CURLOPT_URL, $request->getUrl());
		self::$handles[get_class($request)]->addOption(CURLOPT_HTTPHEADER, $request->getHeaderLines());
		self::$handles[get_class($request)]->addOption(CURLOPT_USERAGENT, $this->getUserAgent());

		$result = self::$handles[get_class($request)]->execute();

		if( self::$handles[get_class($request)]->hasInfo('request_header') ) {
			$request->setSentHeaders(self::$handles[get_class($request)]->getInfo('request_header'));
		}

		$response = ResponseFactory::build($result, self::$handles[get_class($request)]->getInfos());
		$response->setRequest($request);

		return $response;
	}

	/**
	 * Set the client UA for all requests
	 * @return string
	 */
	public function getUserAgent() {
		return 'Bee4 - BeeBot/1.0';
	}
}