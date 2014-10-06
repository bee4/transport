<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2014
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transport\Message
 */

namespace Bee4\Test\Transport\Message;

use Bee4\PHPUnit\HttpClientTestCase;

/**
 * AbstractMessage unit test definition
 * @package Bee4\Test\Transport\Message
 */
class AbstractMessageTest extends HttpClientTestCase
{
	/**
	 * @var \Bee4\Transport\Message\AbstractMessage
	 */
	protected $object;

	/**
	 * Test all headers collection manipulation function
	 */
	public function testAllHeaders() {
		$mock = $this->getMockForAbstractClass(
			'\Bee4\Transport\Message\AbstractMessage'
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
