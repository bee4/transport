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

/**
 * HTTP Message basic implementation
 * @package Bee4\Http\Message
 */
abstract class AbstractMessage implements MessageInterface {
	/**
	 * Protocol name for the current message
	 * @var string
	 */
	protected $protocol = 'HTTP';

	/**
	 * Protocol version for the current message
	 * @var string
	 */
	protected $protocolVersion = '1.1';

	/**
	 * Header collection
	 * @var array
	 */
	protected $headers = [];

	/**
	 * Add a header to the message
	 * @param string $name
	 * @param string $value
	 */
	public function addHeader($name, $value) {
		$this->headers[$name] = $value;
		return $this;
	}

	/**
	 * Add multiple headers at once
	 * @param array $headers
	 */
	public function addHeaders( array $headers ) {
		foreach( $headers as $name => $value ) {
			$this->addHeader($name, $value);
		}
		return $this;
	}

	/**
	 * Check if current message has requested header
	 * @param string $name
	 * @return boolean
	 */
	public function hasHeader($name) {
		return isset($this->headers[$name]);
	}

	/**
	 * Get a header by name
	 * @param string $name
	 * @return string|null
	 */
	public function getHeader($name) {
		if( $this->hasHeader($name) ) {
			return $this->headers[$name];
		}

		return null;
	}

	/**
	 * Get all headers at once in an array
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * Retrieve headers in line format "name: value"
	 * @return array
	 */
	public function getHeaderLines() {
		$headers = array();
		foreach ($this->headers as $name => $value) {
			$headers[] = $name . ': ' . $value;
	  }

		return $headers;
	}

	/**
	 * Remove a header by name
	 * @param string $name
	 */
	public function removeHeader($name) {
		if( $this->hasHeader($name) ) {
			unset($this->headers[$name]);
		}
		
		return $this;
	}

	/**
	 * Remove all headers at once
	 */
	public function removeHeaders() {
		$this->headers = [];
		return $this;
	}
}