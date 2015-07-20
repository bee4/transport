<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message
 */

namespace Bee4\Transport\Message;

/**
 * HTTP Message basic implementation
 * @package Bee4\Transport\Message
 */
abstract class AbstractMessage implements MessageInterface
{
	/**
	 * Header collection
	 * @var array
	 */
	protected $headers = [];

	/**
	 * Add a header to the message
	 * @param string $name
	 * @param string $value
	 * @return AbstractMessage
	 */
	public function addHeader($name, $value) {
		$this->headers[$name] = $value;
		return $this;
	}

	/**
	 * Add multiple headers at once
	 * @param array $headers
	 * @return AbstractMessage
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
	 * @return AbstractMessage
	 */
	public function removeHeader($name) {
		if( $this->hasHeader($name) ) {
			unset($this->headers[$name]);
		}

		return $this;
	}

	/**
	 * Remove all headers at once
	 * @return AbstractMessage
	 */
	public function removeHeaders() {
		$this->headers = [];
		return $this;
	}
}
