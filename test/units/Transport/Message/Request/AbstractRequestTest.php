<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transport\Message\Request
 */

namespace Bee4\Test\Transport\Message\Request;

use Bee4\PHPUnit\HttpClientTestCase;
use Bee4\Transport\Configuration\Configuration;
use Bee4\Transport\Client;
use Bee4\Transport\Url;

/**
 * AbstractRequest test definition
 * @package Bee4\Test\Transport\Message\Request
 */
class AbstractRequestTest extends HttpClientTestCase
{
    /**
     * @var Url
     */
    protected $url;

    /**
     * Build an Url object which represent BaseUrl
     */
    public function setUp()
    {
        $this->url = new Url(self::getBaseUrl());
    }

    /**
     * Check that constructor works well
     */
    public function testConstructor()
    {
        $headers = ['content-type' => 'text/html'];

        $mock = $this->getMockForAbstractClass(
            '\Bee4\Transport\Message\Request\AbstractRequest',
            [$this->url, $headers, new Configuration]
        );

        $this->assertEquals($headers, $mock->getHeaders());
        $this->assertEquals(
            self::getBaseUrl(),
            (string)$mock->getUrl()
        );
    }

    /**
     * @expectedException \Bee4\Transport\Exception\RuntimeException
     */
    public function testInvalidClient()
    {
        $mock = $this->getMockForAbstractClass('\Bee4\Transport\Message\Request\AbstractRequest', [$this->url]);
        $mock->send();
    }

    /**
     * Check that request send method return a valid response object
     */
    public function testSend()
    {
        $mock = $this->getMockForAbstractClass('\Bee4\Transport\Message\Request\AbstractRequest', [$this->url]);
        $mock->setClient(new Client());
        $response = $mock->send();

        $this->assertInstanceOf('\Bee4\Transport\Message\Response', $response);
    }
}
