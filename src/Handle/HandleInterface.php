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
use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Handle factory
 * @package Bee4\Transport\Handle
 */
interface HandleInterface
{
	/**
	 * Execute the handle and retrieve the result
	 */
	public function execute();

	public function getInfo($name);
	public function hasInfo($name);
}