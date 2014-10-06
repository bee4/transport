<?php

/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ftp
 */

namespace Bee4\Transport\Message\Request\Ftp;

/**
 * HTTP HEAD Request object
 * @package Bee4\Transport\Message\Request\Ftp
 */
class Head extends FtpRequest
{
	protected function prepare() {
		$this->addOption(CURLOPT_FTPLISTONLY, true);
	}
}