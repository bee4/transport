<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Http
 */

namespace Bee4\Test\Http;

use Bee4\Http\Client;

/**
 * Http client test
 * @package Bee4\Test\Http
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Client
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 * @covers Bee4\Http\Client::__construct
	 */
	protected function setUp()
	{
		if (!extension_loaded('curl')) {
			$this->markTestSkipped('The curl extension is not available.');
		}

		$this->object = new Client('http://'.WEB_SERVER_HOST.':'.WEB_SERVER_PORT);
	}

	/**
	 * @covers Bee4\Http\Client::getUserAgent
	 */
	public function testGetUserAgent()
	{
		$this->assertEquals('Bee4 - BeeBot/1.0', $this->object->getUserAgent());
	}

	/**
	 * @covers Bee4\Http\Client::createRequest
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidUrl() {
		$method = new \ReflectionMethod('\Bee4\Http\Client', 'createRequest');
		$method->setAccessible(TRUE);
		$method->invoke($this->object, 'GET', new \stdClass());
	}

	/**
	 * @covers Bee4\Http\Client::get
	 * @covers Bee4\Http\Client::createRequest
	 */
	public function testGet()
	{
		$request = $this->object->get('/get.php');
		$this->assertInstanceOf('\Bee4\Http\Message\AbstractMessage', $request);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Get', $request);

		$this->assertEquals('http://'.WEB_SERVER_HOST.':'.WEB_SERVER_PORT.'/get.php', $request->getUrl());

		$response = $request->send();

		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_HTTPGET, $options);
		$this->assertTrue($options[CURLOPT_HTTPGET]);

		$this->assertInstanceOf('\Bee4\Http\Message\Response', $response);
	}
}
