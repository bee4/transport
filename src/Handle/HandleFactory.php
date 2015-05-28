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

use Bee4\Transport\Message\Request\AbstractRequest;

/**
 * Handle factory
 * @package Bee4\Transport\Handle
 */
class HandleFactory
{
	/**
	 * List of already loaded handles
	 * @var array
	 */
	private static $loaded = [];

	/**
	 * Build the Handle instance based on the given request
	 * @param AbstractRequest $request
	 * @return HandleInterface
	 */
	public static function build( AbstractRequest $request ) {
		$name = get_class($request);
		if( !isset(self::$loaded[$name]) ) {
			self::$loaded[$name] = new CurlHandle();
		} else {
			self::$loaded[$name]->reset();
		}
		self::$loaded[$name]->addOptions($request->getOptions());

		return self::$loaded[$name];
	}
}