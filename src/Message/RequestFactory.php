<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transfer\Message
 */

namespace Bee4\Transfer\Message;

use Bee4\Transfer\Url;

/**
 * Static object in charge to build and initialize Request instance
 * @package Bee4\Transfer\Message
 */
class RequestFactory
{
	/**
	 * Build a new request from parameters
	 * @param string $method
	 * @param Url $url
	 * @param array $headers
	 * @return Request\AbstractRequest
	 */
	public function build( $method, Url $url, array $headers ) {
		$name = __NAMESPACE__.'\\Request\\'.ucfirst(strtolower($method));
		if( !class_exists($name) ) {
			throw new \InvalidArgumentException('Method given is not a valid request: '.$method);
		}

		$request = new $name($url, $headers);

		return $request;
	}
}