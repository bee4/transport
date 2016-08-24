<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Transport\Handle
 */

namespace Bee4\Test\Transport\Handle;

use Bee4\PHPUnit\HttpClientTestCase;
use Bee4\Transport\Handle\CurlHandle;

/**
 * Check behaviour of Url helper
 * @package Bee4\Test\Transport\Handle
 */
class CurlHandleTest extends HttpClientTestCase
{
    /**
     * @var CurlHandle
     */
    protected $object;

    public function setUp()
    {
        $this->object = new CurlHandle();
    }

    public function testAll()
    {
        $rfl = (new \ReflectionObject($this->object))->getProperty('options');
        $rfl->setAccessible(true);
        $options = $rfl->getValue($this->object);
        $this->assertArrayHasKey(CURLOPT_HEADER, $options);
        $this->assertArrayHasKey(CURLINFO_HEADER_OUT, $options);
        $this->assertArrayHasKey(CURLOPT_FOLLOWLOCATION, $options);
        $this->assertArrayHasKey(CURLOPT_RETURNTRANSFER, $options);

        $options[CURLOPT_URL] = self::getBaseUrl();
        $rfl->setValue($this->object, $options);

        $result = $this->object->execute();
        $infos = $this->object->infos();
        $this->assertNotNull($infos->headers);
        $this->assertEquals(200, $infos->status);
        $this->assertTrue(is_string($result));
    }

    /**
     * @expectedException \Bee4\Transport\Exception\RuntimeException
     */
    public function testClose()
    {
        $this->object->close();
        $this->object->execute();
    }

    /**
     * @expectedException \Bee4\Transport\Exception\CurlException
     */
    public function testInvalidUrl()
    {
        $rfl = (new \ReflectionObject($this->object))->getProperty('options');
        $rfl->setAccessible(true);
        $options = $rfl->getValue($this->object);
        $options[CURLOPT_URL] = 'invalidUrlToGet';
        $rfl->setValue($this->object, $options);
        $this->object->execute();
    }
}
