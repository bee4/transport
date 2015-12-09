<?php
/**
 * This file is part of the httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2013
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\PHPUnit
 */

namespace Bee4\PHPUnit;

/**
 * Specific HttpClient test case extension.
 * Allow to register the base URL for all tests
 * @package   Bee4\PHPUnit
 */
class HttpClientTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private static $baseURL;

    /**
     * Set the URL that will be used as root in all tests
     * @param string $baseURL The base URL configured
     */
    public static function setBaseUrl($baseURL)
    {
        self::$baseURL = $baseURL;
    }

    /**
     * Base URL accessor
     * @return string
     */
    public static function getBaseUrl()
    {
        return self::$baseURL;
    }
}
