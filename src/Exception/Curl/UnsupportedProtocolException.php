<?php
/**
 * This file is part of the bee4/transport package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Transport\Exception\Curl
 */

namespace Bee4\Transport\Exception\Curl;

use Bee4\Transport\Exception\CurlException;

/**
 * Error thrown when the protocol is not supported by current cURL runtime
 * @package Bee4\Transport\Exception\Curl
 */
class UnsupportedProtocolException extends CurlException
{
}
