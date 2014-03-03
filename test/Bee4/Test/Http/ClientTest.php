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
 * @covers Bee4\Http\Client
 */
class ClientTest extends \Bee4\PHPUnit\HttpClientTestCase
{
	/**
	 * @var Client
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		if (!extension_loaded('curl')) {
			$this->markTestSkipped('The curl extension is not available.');
		}

		$this->object = new Client(self::getBaseUrl());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testNonStringUrl() {
		$method = new \ReflectionMethod('\Bee4\Http\Client', 'createRequest');
		$method->setAccessible(TRUE);
		$method->invoke($this->object, 'get', new \stdClass());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testEmptyUrl() {
		$method = new \ReflectionMethod('\Bee4\Http\Client', 'createRequest');
		$method->setAccessible(TRUE);
		$method->invoke(new Client(), 'post', '');
	}

	public function testGetUserAgent() {
		$this->assertEquals('Bee4 - BeeBot/1.0', $this->object->getUserAgent());
	}

	public function testSend() {
		//Check that Post request is nicely mapped
		$request1 = $this->object->get('/index.html');
		$this->assertEquals(self::getBaseUrl().'/index.html', (string)$request1->getUrl());

		$this->assertInstanceOf('\Bee4\Http\Message\AbstractMessage', $request1);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\AbstractRequest', $request1);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Get', $request1);
		$this->assertInstanceOf('\Bee4\Http\Message\Response', $request1->send());

		//Check that Post request is nicely mapped
		$request2 = $this->object->post('/index.html');
		$this->assertInstanceOf('\Bee4\Http\Message\AbstractMessage', $request2);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\AbstractRequest', $request2);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Post', $request2);
		$this->assertInstanceOf('\Bee4\Http\Message\Response', $request2->send());
	}

	/**
	 * @covers Bee4\Http\Message\Request\Get
	 */
	public function testGet() {
		$request = $this->object->get('/index.html');
		$response = $request->send();
		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_HTTPGET, $options);
		$this->assertTrue($options[CURLOPT_HTTPGET]);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Get', $response->getRequest());
	}

	/**
	 * @covers Bee4\Http\Message\Request\Post
	 */
	public function testPost() {
		$request = $this->object->post('/index.html')->setBody('{"body": "I\'m the body"}}');
		$response = $request->send();
		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_POST, $options);
		$this->assertArrayHasKey(CURLOPT_POSTFIELDS, $options);
		$this->assertTrue($options[CURLOPT_POST]);
		$this->assertEquals('{"body": "I\'m the body"}}', $options[CURLOPT_POSTFIELDS]);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Post', $response->getRequest());
	}

	/**
	 * @covers Bee4\Http\Message\Request\Head
	 */
	public function testHead() {
		$request = $this->object->head('/index.html');
		$response = $request->send();
		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_NOBODY, $options);
		$this->assertTrue($options[CURLOPT_NOBODY]);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Head', $response->getRequest());
	}

	/**
	 * @covers Bee4\Http\Message\Request\Delete
	 */
	public function testDelete() {
		$request = $this->object->delete('/index.html');
		$response = $request->send();
		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_CUSTOMREQUEST, $options);
		$this->assertArrayHasKey(CURLOPT_POSTFIELDS, $options);
		$this->assertEquals('DELETE', $options[CURLOPT_CUSTOMREQUEST]);
		$this->assertEquals(false, $options[CURLOPT_POSTFIELDS]);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Delete', $response->getRequest());
	}

	/**
	 * @covers Bee4\Http\Message\Request\Put
	 */
	public function testPut() {
		$request = $this->object->put('/index.html');
		$response = $request->send();
		$options = $request->getCurlOptions();

		$this->assertArrayHasKey(CURLOPT_CUSTOMREQUEST, $options);
		$this->assertArrayHasKey(CURLOPT_POSTFIELDS, $options);
		$this->assertEquals('PUT', $options[CURLOPT_CUSTOMREQUEST]);
		$this->assertEquals(false, $options[CURLOPT_POSTFIELDS]);
		$this->assertInstanceOf('\Bee4\Http\Message\Request\Put', $response->getRequest());
	}
}
