<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request
 */

namespace Bee4\Transport\Message\Request;

use Bee4\Transport\Exception\UnknownProtocolException;
use Bee4\Transport\Url;

/**
 * Static object in charge to build and initialize Request instance
 * @package Bee4\Transport\Message\Request
 */
class RequestFactory
{
	/**
	 * Build a new request from parameters
	 * @param string $method
	 * @param Url $url
	 * @param array $headers
	 * @return AbstractRequest
	 * @throws UnknownProtocolException
	 * @throws InvalidArgumentException
	 */
	public function build( $method, Url $url, array $headers ) {
		if( $url->scheme() != AbstractRequest::HTTP && $url->scheme() != AbstractRequest::FTP ) {
			throw new UnknownProtocolException("You can't request a transfer on protocol different than FTP or HTTP!");
		}

		$name = __NAMESPACE__.'\\'.ucfirst($url->scheme()).'\\'.ucfirst(strtolower($method));
		if( !class_exists($name) ) {
			throw new \InvalidArgumentException('Method given is not a valid request: '.$method);
		}

		$request = new $name($url, $headers);

		return $request;
	}
}