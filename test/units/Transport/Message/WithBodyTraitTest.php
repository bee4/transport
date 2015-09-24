<?php
/**
 * This file is part of the beebot package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Bee4 2015
 * @author    Stephane HULARD <s.hulard@chstudio.fr>
 * @package   Bee4\Test\Transport\Message
 */

namespace Bee4\Test\Transport\Message;

/**
 * WithBodyTrait unit test definition
 * @package Bee4\Test\Transport\Message
 */
class WithBodyTraitTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test all headers collection manipulation function
	 */
	public function testBody($mock = null) {
		if( null === $mock ) {
			$mock = $this->getObjectForTrait('Bee4\Transport\Message\WithBodyTrait');
		}

		$body = 'Just a sample body';

		$this->assertFalse($mock->getBody());
		$mock->setBody($body);
		$this->assertEquals($body, $mock->getBody());
		$this->assertEquals(strlen($body), $mock->getBodyLength());
	}
}
