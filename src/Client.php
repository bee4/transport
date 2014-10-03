<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

use Bee4\Events\DispatcherAwareTrait;
use Bee4\Transport\Exception\CurlException;
use Bee4\Transport\Message\Request\RequestInterface;
use Closure;
use Bee4\Transport\Message\Request\AbstractRequest;
use Bee4\Transport\Message\Request\RequestFactory;
use Bee4\Transport\Message\ResponseFactory;

/**
 * Http client
 * @package Bee4\Transport
 *
 * @method AbstractRequest get(string $url = "", array $headers = [])
 * @method AbstractRequest post(string $url = "", array $headers = [])
 * @method AbstractRequest head(string $url = "", array $headers = [])
 * @method AbstractRequest delete(string $url = "", array $headers = [])
 * @method AbstractRequest put(string $url = "", array $headers = [])
 */
class Client
{
	use DispatcherAwareTrait;

	/**
	 * Triggered when the request is totally built
	 */
	const ON_REQUEST = 'request.built';
	/**
	 * Triggered when an error occured during request sending
	 */
	const ON_ERROR = 'request.error';
	/**
	 * Triggered when a response in built
	 */
	const ON_RESPONSE = 'response.built';

	/**
	 * Base URL for calls
	 * @var Url
	 */
	protected $baseUrl;

	/**
	 * Handle collection to be used to prevent bind problem
	 * @var array
	 */
	protected static $handles = [];

	/**
	 * The factory to build request messages
	 * @var RequestFactory
	 */
	protected $requestFactory;

	/**
	 * Contain a list of handlers to be triggered at some process actions
	 * @var array
	 */
	protected $events = [
		self::ON_REQUEST => [],
		self::ON_ERROR => [],
		self::ON_RESPONSE => []
	];

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

		if( $baseUrl != '' ) {
			$this->baseUrl = new Url($baseUrl);
		}

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
		$arguments[0] = isset($arguments[0])?$arguments[0]:'';

		array_unshift($arguments, $name);
		return call_user_func_array([$this, 'createRequest'], $arguments);
	}

	/**
	 * Create the request object
	 * @param string $method
	 * @param string $url
	 * @param array $headers
	 * @return RequestInterface
	 */
	protected function createRequest( $method, $url, array $headers = [] ) {
		if( !is_string($url) ) {
			throw new \InvalidArgumentException('Url parameter must be a valid string!!');
		}

		$url = new Url((isset($this->baseUrl)?$this->baseUrl->toString():'').$url);

		$request = $this->requestFactory->build($method, $url, $headers);
		$request->setClient($this);

		return $request;
	}

	/**
	 * Send the request
	 * @param RequestInterface $request The request to be send
	 * @return Message\Response
     * @throws CurlException
	 */
	public function send( RequestInterface $request ) {
		$name = get_class($request);
		if( !isset(self::$handles[$name]) ) {
			self::$handles[$name] = new Curl\Handle();
		}

		self::$handles[$name]->addOptions($request->getCurlOptions());
		$this->trigger(self::ON_REQUEST, $request);

		try {
			$result = self::$handles[$name]->execute();
		} catch( CurlException $error ) {
			$this->trigger(self::ON_ERROR, $error);
			throw $error;
		}

		$response = ResponseFactory::build( $result, self::$handles[$name], $request );
		$this->trigger(self::ON_RESPONSE, $response);

		return $response;
	}

	/**
	 * Trigger an event on current client instance
	 * @param string $name
	 * @param mixed $data
	 */
	private function trigger($name, $data) {
		foreach( $this->events[$name] as $handler ) {
			call_user_func($handler, $data);
		}
	}

	/**
	 * Register a callback executed when event is encountered
	 * @param string $event
	 * @param Closure $callback
	 * @throws \RuntimeException
	 */
	public function register($event, Closure $callback) {
		if( !in_array($event, array_keys($this->events)) ) {
			throw new \InvalidArgumentException("You must used one of the registerable events!");
		}
		$this->events[$event][] = $callback;
	}
}