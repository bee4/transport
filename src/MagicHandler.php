<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Add some magic method handling to the default client
 * @package Bee4\Transport
 *
 * @method AbstractRequest get(string $url = "", array $headers = [])
 * @method AbstractRequest post(string $url = "", array $headers = [])
 * @method AbstractRequest head(string $url = "", array $headers = [])
 * @method AbstractRequest delete(string $url = "", array $headers = [])
 * @method AbstractRequest put(string $url = "", array $headers = [])
 */
class MagicHandler implements ClientInterface
{
	protected $client;

	/**
	 * @param Client $c
	 */
	public function __construct( Client $c ) {
		$this->client = $c;
	}

	/**
	 * Send decoration, rely to given client
	 * @param  AbstractRequest $request
	 * @return Message\Response
	 */
	public function send( AbstractRequest $request ) {
		return $this->client->send($request);
	}

	/**
	 * Create decoration, rely to given client
	 * @param string $method
	 * @param string $url
	 * @param array $headers
	 * @return AbstractRequest
	 */
	public function createRequest( $method, $url = '', array $headers = [] ) {
		return $this->client->createRequest($method, $url, $headers);
	}

	/**
	 * Magic method to implement dynamically all request types that are defined.
	 * The request factory can't build a valid object, an exception is thrown
	 * @param string $name The method name
	 * @param array $arguments Argument collection to be used to build request
	 * @return AbstractRequest
	 */
	public function __call( $name, array $arguments = [] ) {
		//Send all others method directly to the client
		if( method_exists($this->client, $name) ) {
			return call_user_func_array([$this->client, $name], $arguments);
		}

		//Then handle magic HTTP name calls
		$arguments[0] = isset($arguments[0])?$arguments[0]:'';
		array_unshift($arguments, $name);
		return call_user_func_array([$this, 'createRequest'], $arguments);
	}
}