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

use Bee4\Http\Message\Response;

/**
 * Response unit test definition
 * @package Bee4\Test\Http\Message
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Response
	 */
	protected $object;

	public function setUp() {
		$this->object = new Response();
	}

	public function testIntegrity() {
		$uses = class_uses(get_class($this->object));
		$this->assertContains('Bee4\Http\Message\WithBodyTrait', $uses);
	}

	public function testSetters() {
		$request = $this->getMockForAbstractClass(
			'\Bee4\Http\Message\Request\AbstractRequest',
			[ new \Bee4\Http\Url('http://www.bee4.fr') ]
		);
		$this->object->setRequest($request);
		$this->assertEquals($request, $this->object->getRequest());

		$this->object->setStatus(200);
		$this->assertEquals(200, $this->object->getStatus());

		$this->object->setResponseTime(1.5);
		$this->assertEquals(1.5, $this->object->getResponseTime());
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testResponseTime() {
		$this->object->setResponseTime(-0.8);
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testResponseTimeAgain() {
		$this->object->setResponseTime('hello world');
	}

	/**
	 * @expectedException \RuntimeException
	 */
	public function testJson() {
		$this->object->setBody('{"key":"value"}');
		$this->assertEquals(["key"=>"value"], $this->object->json());

		$this->object->setBody('{invalidJson}');
		$this->object->json();
	}
}
