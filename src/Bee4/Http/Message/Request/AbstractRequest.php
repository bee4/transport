<?php

/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http\Message\Request
 */

namespace Bee4\Http\Message\Request;

use Bee4\Http\Message\AbstractMessage;
use Bee4\Http\Client;

/**
 * HTTP Request object
 * @package Bee4\Http\Message\Request
 */
abstract class AbstractRequest extends AbstractMessage {
	/**
	 * Current client instance
	 * @var Client
	 */
	protected $client;

	/**
	 * cURL option list specific for the current request
	 * @var array
	 */
	protected $options;

	/**
	 * URL for the request
	 */
	protected $url;

	/**
	 * Sent headers
	 * @var string
	 */
	protected $sentHeaders = "";

	/**
	 * Construct a new request object
	 * @param string $url
	 * @param array $headers
	 */
	public function __construct($url, array $headers = []) {
		$this->url = $url;
		$this->addHeaders($headers);
	}

	/**
	 * Set the linked client
	 * @param Client $client
	 */
	public function setClient( Client $client ) {
		$this->client = $client;
		return $this;
	}

	/**
	 * URL accessor
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * cURL option collection accessor
	 * @return array
	 */
	public function getCurlOptions() {
		return $this->options;
	}

	/**
	 * Add specifically curl option list to current request
	 * @param array $options
	 * @return AbstractRequest
	 */
	public function addCurlOptions(array $options) {
		foreach( $options as $name => $value ) {
			$this->addCurlOption($name, $value);
		}

		return $this;
	}

	/**
	 * Add an option for current request
	 * @param int $name
	 * @param mixed $value
	 * @return AbstractRequest
	 */
	public function addCurlOption($name, $value) {
		$this->options[$name] = $value;

		return $this;
	}

	public function setSentHeaders( $headers ) {
		$this->sentHeaders = $headers;
	}
	public function getSentHeaders() {
		return $this->sentHeaders;
	}

	/**
	 * Prepare the request execution by adding specific cURL parameters
	 */
	abstract protected function prepare();

	/**
	 * Send method.
	 * To send a request, a client must be linked
	 * @return \Bee4\Http\Message\Response
	 */
	public function send() {
		if (!$this->client) {
      throw new \RuntimeException('A client must be set on the request');
    }

    $this->prepare();
    return $this->client->send($this);
	}
}