<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author	Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Message\Request\Ftp
 */

namespace Bee4\Transport\Message\Request\Ftp;

use Bee4\Transport\Message\WithBodyTrait;

/**
 * Ftp Put Request object => Use to upload files to remote
 * @package Bee4\Transport\Message\Request\Ftp
 */
class Put extends FtpRequest
{
	use WithBodyTrait;

	protected function prepare() {
		parent::prepare();

		if( false === $stream = tmpfile() ) {
			throw new \RuntimeException("Can't create temporary file !");
		}
		fwrite($stream, $this->getBody());
		rewind($stream);

		$this->addOption(CURLOPT_URL, $this->getUrl());
		$this->addOption(CURLOPT_UPLOAD, true);
		$this->addOption(CURLOPT_INFILE, $stream);
		$this->addOption(CURLOPT_INFILESIZE, strlen($this->getBody()));
	}
}