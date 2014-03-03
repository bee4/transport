<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
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
		// @codeCoverageIgnoreStart
		if (!extension_loaded('curl')) {
			throw new \RuntimeException('The PHP cURL extension must be installed!');
		}
		// @codeCoverageIgnoreEnd

		$this->baseUrl = $baseUrl;
		$this->requestFactory = new RequestFactory();
	}

	/**
	 * Magic method to implement dynamically all request types that are defined.
	 * The request factory can't build a valid object, an exception is thrown
	 * @param string $name The method name
	 * @param array $arguments Argument collection to be used to build request
	 * @return AbstractRequest
	 */
	public function __call( $name, array $arguments = [] ) {
		$arguments[0] = $this->baseUrl.(isset($arguments[0])?$arguments[0]:'');

		array_unshift($arguments, $name);
		return call_user_func_array([$this, 'createRequest'], $arguments);
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
			throw new \InvalidArgumentException('URL given must be a valid URL and can\'t be empty');
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

		if( self::$handles[get_class($request)]->hasInfo(CURLINFO_HEADER_OUT) ) {
			$request->setSentHeaders(self::$handles[get_class($request)]->getInfo(CURLINFO_HEADER_OUT));
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