<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message
 */
namespace Bee4\Transport\Message;

/**
 * Add body capability to the current request
 * @package Bee4\Transport\Message
 */
trait WithBodyTrait
{
	/**
	 * Request body
	 * @var string
	 */
	protected $body = false;

	/**
	 * Set the body for the current request
	 * @param string $body
	 * @return WithBodyTrait
	 */
	public function setBody($body) {
		$this->body = $body;
		return $this;
	}

	/**
	 * Return the body property
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}
}
