<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transport\Message\Request
 */

namespace Bee4\Test\Transport\Message\Request;

use Bee4\PHPUnit\HttpClientTestCase;
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
	public function setUp() {
		$this->url = new Url(self::getBaseUrl());
	}

	/**
	 * Check that constructor works well
	 */
	public function testConstructor() {
		$headers = ['Content-Type' => 'text/html'];

		$mock = $this->getMockForAbstractClass(
			'\Bee4\Transport\Message\Request\AbstractRequest',
			[$this->url, $headers]
		);

		$this->assertEquals($headers, $mock->getHeaders());
		$this->assertEquals(
			self::getBaseUrl(),
			(string)$mock->getUrl()
		);
	}

	/**
	 * Check curl option collection manipulation
	 */
	public function testCurlOptions() {
		$mock = $this->getMockForAbstractClass('\Bee4\Transport\Message\Request\AbstractRequest', [$this->url]);

		$this->assertEmpty($mock->getCurlOptions());
		$mock->addCurlOption(CURL_HTTP_VERSION_1_1, true);
		$mock->addCurlOptions([CURLOPT_AUTOREFERER => true, CURLOPT_CONNECTTIMEOUT => 10]);

		$options = $mock->getCurlOptions();
		$this->assertArrayHasKey(CURLOPT_CONNECTTIMEOUT, $options);
		$this->assertArrayHasKey(CURLOPT_AUTOREFERER, $options);
		$this->assertArrayHasKey(CURL_HTTP_VERSION_1_1, $options);

		$this->assertTrue($options[CURLOPT_AUTOREFERER]);
		$this->assertEquals(10, $options[CURLOPT_CONNECTTIMEOUT]);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testInvalidClient() {
		$mock = $this->getMockForAbstractClass('\Bee4\Transport\Message\Request\AbstractRequest', [$this->url]);
		$mock->send();
	}

	/**
	 * Check that request send method return a valid response object
	 */
	public function testSend() {
		$mock = $this->getMockForAbstractClass('\Bee4\Transport\Message\Request\AbstractRequest', [$this->url]);
		$mock->setClient(new Client());
		$response = $mock->send();

		$this->assertInstanceOf('\Bee4\Transport\Message\Response', $response);
	}
}
