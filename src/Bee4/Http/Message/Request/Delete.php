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

/**
 * HTTP DELETE Request object
 * @package Bee4\Http\Message\Request
 */
class Delete extends AbstractRequest
{
	use \Bee4\Http\Message\WithBodyTrait;

	protected function prepare() {
		$this->options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
		$this->options[CURLOPT_POSTFIELDS] = $this->getBody();
	}
}