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
	 * Request dependency injection
	 * @param Request $request
	 */
	public function setRequest( AbstractRequest $request ) {
		$this->request = $request;
		return $this;
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

	public function json() {
		$json = json_decode($this->getBody(), true);
		if( $json === null ) {
			ob_start();
			var_dump($this->getBody());
			$dump = ob_get_clean();
			throw new \RuntimeException(
				"Can't decode JSON response: ".PHP_EOL.
				"URL: ".$this->request->getUrl().PHP_EOL.
				"Sent headers: ".PHP_EOL.$this->request->getSentHeaders().PHP_EOL.
				"Sent BODY: ".PHP_EOL.$this->request->getBody().PHP_EOL.
				"Received headers: ".PHP_EOL.implode(PHP_EOL, $this->getHeaderLines()).PHP_EOL.
				"Received body: ".PHP_EOL.$dump
			);
		}
		return $json;
	}
}
