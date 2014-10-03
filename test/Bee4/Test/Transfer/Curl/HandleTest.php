<?php
/**
 * This file is part of the bee4/httpclient package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author  Stephane HULARD <s.hulard@chstudio.fr>
 * @package Bee4\Test\Transfer\Curl
 */

namespace Bee4\Test\Http;

use Bee4\PHPUnit\HttpClientTestCase;
use Bee4\Transfer\Curl\Handle;

/**
 * Check behaviour of Url helper
 * @package Bee4\Test\Transfer\Curl
 */
class HandleTest extends HttpClientTestCase {
	/**
	 * @var Handle
	 */
	protected $object;

	public function setUp() {
		$this->object = new Handle();
	}

	public function testAll() {
		$this->assertTrue($this->object->hasOption(CURLOPT_HEADER));
		$this->assertTrue($this->object->hasOption(CURLINFO_HEADER_OUT));

		$this->object->addOption(CURLOPT_FOLLOWLOCATION, false);
		$this->assertTrue($this->object->hasOption(CURLINFO_HEADER_OUT));

		$this->object->addOption(CURLOPT_URL, self::getBaseUrl());
		$this->assertTrue($this->object->hasOption(CURLOPT_URL));

		$result = $this->object->execute();

		$this->assertTrue($this->object->hasInfo('request_header'));
		$this->assertEquals(200, $this->object->getInfo('http_code'));
		$this->assertNull($this->object->getInfo('unknown_property'));
		$this->assertTrue(is_string($result));

		$this->assertArrayHasKey('content_type', $this->object->getInfos());

		unset($this->object);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testClose() {
		$this->object->close();
		$this->object->execute();
	}

	/**
	 * @expectedException \Bee4\Transfer\Exception\CurlException
	 */
	public function testInvalidUrl() {
		$this->object->addOptions([CURLOPT_URL => 'invalidUrlToGet']);
		$this->object->execute();
	}
}
