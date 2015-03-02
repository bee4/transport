<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

use Bee4\Events\DispatcherAwareTrait;
use Bee4\Transport\Events\ErrorEvent;
use Bee4\Transport\Events\MessageEvent;
use Bee4\Transport\Exception\CurlException;
use Bee4\Transport\Message\Request\AbstractRequest;
use Bee4\Transport\Message\Request\RequestFactory;
use Bee4\Transport\Message\ResponseFactory;
use Bee4\Transport\Handle\HandleFactory;

/**
 * Transport client, generate a request and return the linked response
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
	 * Base URL for calls
	 * @var Url
	 */
	protected $baseUrl;

	/**
	 * The factory to build request messages
	 * @var RequestFactory
	 */
	protected $requestFactory;

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
	 * @return AbstractRequest
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
	 * @param AbstractRequest $request The request to be send
	 * @return Message\Response
	 * @throws \Exception
	 */
	public function send( AbstractRequest $request ) {
		$handle = HandleFactory::build($request);
		$this->dispatch(MessageEvent::REQUEST, new MessageEvent($request));

		try {
			$result = $handle->execute();
		} catch( \Exception $error ) {
			if( $error instanceof CurlException ) {
				$response = ResponseFactory::build( '', $handle, $request );
				$error->setResponse($response);
			}
			$this->dispatch(ErrorEvent::ERROR, new ErrorEvent($error));
			throw $error;
		}

		$response = ResponseFactory::build( $result, $handle, $request );
		$this->dispatch(MessageEvent::RESPONSE, new MessageEvent($response));

		return $response;
	}
}