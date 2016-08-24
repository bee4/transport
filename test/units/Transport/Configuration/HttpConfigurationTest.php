<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Transport
 */

namespace Bee4\Test\Transport;

use Bee4\Transport\Configuration\HttpConfiguration;

/**
 * @package Bee4\Test\Transport
 */
class HttpConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $conf = new HttpConfiguration();

        $this->assertArrayHasKey('allow_redirects', $conf);
        $this->assertArrayHasKey('user_agent', $conf);
        $this->assertArrayHasKey('accept_encoding', $conf);
    }

    public function testAllowRedirect()
    {
        $conf = new HttpConfiguration(['allow_redirects' => false]);
        $this->assertFalse($conf->redirectsAllowed());

        $this->assertNull($conf->allowRedirectsMax());
        $conf->allowRedirectsMax(1);
        $this->assertTrue($conf->redirectsAllowed());
        $this->assertEquals(1,$conf->allowRedirectsMax());
        $this->assertTrue($conf->allowRedirectsReferer());
        $conf->allowRedirectsReferer(false);
        $this->assertFalse($conf->allowRedirectsReferer());
    }
}
