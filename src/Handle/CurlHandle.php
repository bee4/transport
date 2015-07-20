<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Handle
 */

namespace Bee4\Transport\Handle;

use Bee4\Transport\Exception\CurlException;

/**
 * Define cURL handle wrapper
 * @package Bee4\Transport\Handle
 */
class CurlHandle extends AbstractHandle
{
	/**
	 * cURL resource handle
	 * @var resource
	 */
	protected $handle;

	/**
	 * Initialize cURL resource
	 */
	public function __construct() {
		$this->options = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => true,
			CURLINFO_HEADER_OUT => true
		];

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
	 * Check PHP version and reset handle option if possible
	 * @return boolean
	 */
	public function reset() {
		if( is_resource($this->handle) && function_exists('curl_reset') ) {
			curl_reset($this->handle);
			return true;
		}

		return false;
	}
}
