<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http\Message
 */

namespace Bee4\Http\Message;

use Bee4\Http\Message\Request\AbstractRequest;

/**
 * Response wrapper
 * @package Bee4\Http\Message
 */
class Response extends AbstractMessage {
	use \Bee4\Http\Message\WithBodyTrait;

	/**
	 * The request which allow to generate this response
	 * @var AbstractRequest
	 */
	protected $request;

	/**
	 * HTTP Status code
	 * @var integer
	 */
	protected $status;

	/**
	 * HTTP Response time
	 * @var integer
	 */
	protected $time;

	/**
	 * Request dependency injection
	 * @param AbstractRequest $request
	 */
	public function setRequest( AbstractRequest $request ) {
		$this->request = $request;
		return $this;
	}

	/**
	 *
	 * @return AbstractRequest
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Set the response status code
	 * @param int $code
	 */
	public function setStatus($code) {
		$this->status = (int)$code;
		return $this;
	}

	/**
	 * Retrieve request status code
	 * @return int
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Set the response time
	 * @param int $time
	 * @throws \RuntimeException
	 */
	public function setResponseTime($time) {
		if( !is_numeric($time) || $time < 0 ) {
			throw new \RuntimeException(
				"Strange response time"
			);
		}
		$this->time = (float)$time;
		return $this;
	}

	/**
	 * Retrieve request response time
	 * @return int
	 */
	public function getResponseTime() {
		return $this->time;
	}

	/**
	 * Try to json_decode the response body
	 * @return string
	 * @throws \RuntimeException
	 */
	public function json() {
		$json = json_decode($this->getBody(), true);
		if( $json === null ) {
			throw new \RuntimeException(
				"Can't decode JSON response: ".$json
			);
		}
		return $json;
	}
}
