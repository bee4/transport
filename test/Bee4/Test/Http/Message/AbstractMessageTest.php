<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Http\Message
 */

namespace Bee4\Test\Http\Message;

/**
 * AbstractMessage unit test definition
 * @package Bee4\Test\Http\Message
 */
class AbstractMessageTest extends \Bee4\PHPUnit\HttpClientTestCase
{
	/**
	 * @var \Bee4\Http\Message\AbstractMessage
	 */
	protected $object;

	protected function setUp()
	{
	}

	/**
	 * Test all headers collection manipulation function
	 */
	public function testAllHeaders() {
		$mock = $this->getMockForAbstractClass(
			'\Bee4\Http\Message\AbstractMessage'
		);

		$mock->addHeader('Content-Type', 'text/html');
		$this->assertTrue($mock->hasHeader('Content-Type'));
		$this->assertFalse($mock->hasHeader('Content-Length'));

		$this->assertNull($mock->getHeader('Content-Length'));
		$this->assertEquals('text/html', $mock->getHeader('Content-Type'));

		$headers = ['Content-Type' => 'application/json', 'Content-Length' => 0];
		$mock->addHeaders($headers);
		$this->assertEquals($headers, $mock->getHeaders());

		$this->assertEquals(["Content-Type: application/json", "Content-Length: 0"], $mock->getHeaderLines());

		$mock->removeHeader('Content-Type');
		$this->assertNull($mock->getHeader('Content-Type'));
		$mock->removeHeaders();
		$this->assertCount(0, $mock->getHeaders());
	}
}
