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

        $this->assertArrayHasKey('connect_timeout', $conf);
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

    public function testSslVerify()
    {
        $conf = new Configuration();

        $this->assertFalse($conf->verify);
        $conf->verify = true;
        $this->assertTrue($conf->verify);
    }
}
