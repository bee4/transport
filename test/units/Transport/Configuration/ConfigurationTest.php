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

use Bee4\Transport\Configuration\Configuration;

/**
 * @package Bee4\Test\Transport
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaults()
    {
        $conf = new Configuration();

        $this->assertArrayHasKey('allow_redirects', $conf);
        $this->assertArrayHasKey('user_agent', $conf);
        $this->assertArrayHasKey('allow_redirects', $conf);
        $this->assertArrayHasKey('connect_timeout', $conf);
        $this->assertArrayHasKey('http_errors', $conf);
        $this->assertArrayHasKey('timeout', $conf);
        $this->assertArrayHasKey('verify', $conf);
        $this->assertArrayHasKey('url', $conf);
        $this->assertArrayHasKey('body', $conf);
        $this->assertArrayHasKey('method', $conf);
        $this->assertArrayHasKey('upload', $conf);
        $this->assertEquals('GET', $conf->method);
        $this->assertEquals(null, $conf->url);
        $this->assertEquals(null, $conf->body);
        $this->assertEquals(false, $conf->upload);
    }

    public function testTimeout()
    {
        $conf = new Configuration();

        $this->assertEquals(30, $conf->timeout);
        $conf->timeout = 120;
        $this->assertEquals(120, $conf->timeout);
    }

    public function testHttpErrors()
    {
        $conf = new Configuration();

        $this->assertFalse($conf->http_errors);
        $conf->http_errors = true;
        $this->assertTrue($conf->http_errors);
    }

    public function testSslVerify()
    {
        $conf = new Configuration();

        $this->assertFalse($conf->verify);
        $conf->verify = true;
        $this->assertTrue($conf->verify);
    }

    public function testAllowRedirect()
    {
        $conf = new Configuration(['allow_redirects' => false]);
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
