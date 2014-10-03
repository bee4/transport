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

use Bee4\Transport\Message\AbstractMessage;
use Bee4\Transport\Client;
use Bee4\Transport\Url;

/**
 * HTTP Request object
 * @package Bee4\Transport\Message\Request
 */
abstract class AbstractRequest extends AbstractMessage implements RequestInterface
{
	/**
	 * Current client instance
	 * @var Client
	 */
	protected $client;

	/**
	 * specific cURL options for the current request
	 * @var array
	 */
	protected $options;

	/**
	 * @var Url
	 */
	protected $url;

	/**
	 * Construct a new request object
	 * @param Url $url
	 * @param array $headers
	 */
	public function __construct(Url $url, array $headers = []) {
		$this->url = $url;
		$this->options = [];
		$this->addHeaders($headers);
	}

	/**
	 * Set the linked client
	 * @param Client $client
     * @return AbstractRequest
	 */
	public function setClient( Client $client ) {
		$this->client = $client;
		return $this;
	}

	/**
	 * URL accessor
	 * @return Url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * cURL option collection accessor
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * Add specifically curl option list to current request
	 * @param array $options
	 * @return AbstractRequest
	 */
	public function addOptions(array $options) {
		foreach( $options as $name => $value ) {
			$this->addOption($name, $value);
		}

		return $this;
	}

	/**
	 * Add an option for current request
	 * @param int $name
	 * @param mixed $value
	 * @return AbstractRequest
	 */
	public function addOption($name, $value) {
		$this->options[$name] = $value;

		return $this;
	}

	/**
	 * Prepare the request execution by adding specific cURL parameters
	 */
	abstract protected function prepare();

	/**
	 * Send method.
	 * To send a request, a client must be linked
	 * @return \Bee4\Transport\Message\Response
	 */
	public function send() {
		if (!$this->client) {
          throw new \RuntimeException('A client must be set on the request');
        }

		$this->addOption(CURLOPT_URL, $this->getUrl()->toString());

        $this->prepare();
        return $this->client->send($this);
	}
}