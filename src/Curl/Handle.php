<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Http\Curl
 */

namespace Bee4\Http\Curl;

use \Bee4\Http\Exception\CurlException;

/**
 * Define cURL handle wrapper
 * @package Bee4\Http\Curl
 */
class Handle
{
	/**
	 * cURL option to be used to execute current handle
	 * @var array
	 */
	protected $options = [
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HEADER => true,
		CURLINFO_HEADER_OUT => true
	];

	/**
	 * cURL resource handle
	 * @var resource
	 */
	protected $handle;

	/**
	 * cURL last execution details
	 * @var array
	 */
	protected $infos = [];

	/**
	 * Initialize cURL resource
	 */
	public function __construct() {
		$this->open();
	}

	/**
	 * Handle destructor
	 * @codeCoverageIgnore
	 */
	public function __destruct() {
		$this->close();
	}

	/**
	 * Open the curl handle to be used
	 * @return Handle
	 */
	public function open() {
		if( !is_resource($this->handle) ) {
			$this->handle = curl_init();
		}
		return $this;
	}

	/**
	 * Close currently opened handle
	 * @return Handle
	 */
	public function close() {
		if( is_resource($this->handle) ) {
			curl_close($this->handle);
		}
		$this->handle = null;
		return $this;
	}

	/**
	 * Execute current handle and return result
     * @throws \RuntimeException
     * @throws CurlException
	 * @return string
	 */
	public function execute() {
		if( !is_resource($this->handle) ) {
			throw new \RuntimeException('Curl handle has been closed, just open it before execute...');
		}

		curl_setopt_array($this->handle, $this->options);

		$return = curl_exec($this->handle);
		$this->infos = curl_getinfo($this->handle);
		if( $return === false ) {
			throw new CurlException(
				curl_error($this->handle),
				curl_errno($this->handle)
			);
		}

		return $return;
	}

	/**
	 * Check if curl execution contain requested info
	 * @param string $name
	 * @return boolean
	 */
	public function hasInfo($name) {
		return isset($this->infos[$name]);
	}

	/**
	 * Return cURL last execution detail
	 * @param string $name
	 * @return int|string|double
	 */
	public function getInfo($name) {
		if( $this->hasInfo($name) ) {
			return $this->infos[$name];
		}

		return null;
	}

	/**
	 * Retrieve all infos
	 * @return array
	 */
	public function getInfos() {
		return $this->infos;
	}

	/**
	 * Check if option is defined
	 * @param int $name must be a CURL_XX constant
	 * @return boolean
	 */
	public function hasOption($name) {
		return isset($this->options[$name]);
	}

	/**
	 * Add an option to the handle
	 * @param int $name
	 * @param mixed $value
	 * @return Handle
	 */
	public function addOption( $name, $value ) {
		$this->options[$name] = $value;
		return $this;
	}

	/**
	 * Add multiple option at once
	 * @param array $options
	 * @return Handle
	 */
	public function addOptions( array $options ) {
		foreach( $options as $name => $value ) {
			$this->addOption($name, $value);
		}
		return $this;
	}
}