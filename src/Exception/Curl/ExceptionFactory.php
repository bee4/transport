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
 * Error thrown when the URL is considered malformed by cURL
 * @package Bee4\Transport\Exception\Curl
 */
class ExceptionFactory
{
    public static function build($code, $message)
    {
        $error = null;
        switch($code) {
            case CURLE_UNSUPPORTED_PROTOCOL:
                $error = new UnsupportedProtocolException($message, $code);
                break;
            case CURLE_URL_MALFORMAT:
                $error = new MalformedUrlException($message, $code);
                break;
            default:
                $error = new CurlException($message, $code);
                break;
        }
        return $error;
    }
}
