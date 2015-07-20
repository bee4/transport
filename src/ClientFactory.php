<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport
 */

namespace Bee4\Transport;

/**
 * A client builder
 * @package Bee4\Transport
 */
class ClientFactory
{
	protected function __construct() {
		//Just a factory helper, can't be instantiated
	}

	/**
	 * Create a new client instance
	 * @param  string $url The root URL used by the client
	 * @return ClientInterface The generated instance
	 */
	public static function create($url = '') {
		$instance = new Client($url);
		return new MagicHandler($instance);
	}
}
